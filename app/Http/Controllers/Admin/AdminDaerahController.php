<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDaerah;
use App\Models\Daerah;
use App\Models\Kota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\File;

class AdminDaerahController extends Controller
{
    public function index()
    {
        $kota = Kota::all();
        $data['kota'] = $kota;
        $daerah = Daerah::all();
        $data['daerah'] = $daerah;
        $admin = AdminDaerah::all();
        $data['admin'] = $admin;
        return view('Admin.admindaerah.index', $data);
    }

    public function create()
    {
        $kotas = Kota::orderBy('nama_kota', 'ASC')->get();
        $data['kotas'] = $kotas;
        $daerahs = Daerah::orderBy('nama_daerah', 'ASC')->get();
        $data['daerahs'] = $daerahs;
        $admins = AdminDaerah::orderBy('nama', 'ASC')->get();
        $data['admins'] = $admins;
        return view('admin.admindaerah.create', $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmed'
            ],
            'nama' => 'required|string|max:255', // Validasi untuk 'name'
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Validasi untuk 'photo'
            // Tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $params1 = $request->all();
        $params2 = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ];

        if ($request->has('photo')) {
            $params1['photo'] = $this->simpanImage('adminderah', $request->file('photo'), $params1['nama']);
        }

        $user = User::create($params2);
        if ($user) {
            // Mengambil data 'nama_kota' berdasarkan 'daerah_id' dari tabel 'kota'
            $daerah = Daerah::where('id', $params1['daerah_id'])->first();

            if ($daerah) {
                $params1['user_id'] = $user->id;
                $params1['nama_kota'] = $daerah->kota->nama_kota;
                $admin = AdminDaerah::create($params1);

                if ($admin) {
                    alert()->success('Success', 'Data Berhasil Disimpan');
                } else {
                    $user->delete();
                    alert()->error('Error', 'Data Gagal Disimpan');
                }
            } else {
                $user->delete();
                alert()->error('Error', 'Daerah ID tidak valid');
            }
        }

        return redirect()->route('admin.admindaerah.index');
    }


    public function edit($id)
    {
        $kotas = Kota::orderBy('nama_kota', 'ASC')->get();
        $data['kotas'] = $kotas;
        $daerahs = Daerah::orderBy('nama_daerah', 'ASC')->get();
        $data['daerahs'] = $daerahs;
        $admin = AdminDaerah::findOrFail(Crypt::decrypt($id));
        $data['data'] = $admin;
        return view('admin.admindaerah.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // Mengambil data admin dan user yang akan diperbarui
        $admin = AdminDaerah::findOrFail(Crypt::decrypt($id));
        $user = User::findOrFail($admin->user_id);

        // Validasi data admin
        $adminValidator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Validasi data user
        $userValidatorRules = [
            'password' => [
                'nullable',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmed'
            ],
        ];

        // Validasi email hanya jika ada perubahan
        if ($user->email != $request->input('email')) {
            $userValidatorRules['email'] = 'nullable|email|unique:users,email,' . $user->id;
        }

        $userValidator = Validator::make($request->all(), $userValidatorRules);

        if ($adminValidator->fails() || $userValidator->fails()) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($adminValidator->errors()->toArray(), $userValidator->errors()->toArray()))
                ->withInput();
        }

        // Mengupdate data admin
        $adminParams = $request->only(['nama', 'photo']);
        if ($request->has('photo')) {
            $adminParams['photo'] = $this->simpanImage('admindaerah', $request->file('photo'), $adminParams['nama']);
        } else {
            $adminParams = $request->except('photo');
        }
        $admin->update($adminParams);

        // Mengupdate data user jika password diisi
        $userParams = [];
        if ($request->filled('password')) {
            $userParams['password'] = Hash::make($request->password);
        }

        // Mengupdate email hanya jika ada perubahan
        if ($user->email != $request->input('email')) {
            $userParams['email'] = $request->input('email');
        }
        $user->update($userParams);

        if ($admin->update($adminParams) && $user->update($userParams)) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }
        return redirect()->route('admin.admindaerah.index');
    }

    public function destroy($id)
    {
        $admin = AdminDaerah::findOrFail(Crypt::decrypt($id));
        if ($admin->delete()) {
            $user = User::findOrFail($admin->user_id);
            $user->delete();
            alert()->success('Success', 'Data Berhasil Dihapus');
        }
        return redirect()->route('admin.admindaerah.index');
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('storage/uploads/profil/' . $type . '/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . $nama . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/profil/' . $type . '/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }

        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
