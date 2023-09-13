<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supir;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\File;

class SupirController extends Controller
{
    public function index()
    {
        $Supir = Supir::all();
        $data['supir'] = $Supir;
        return view('admin.supir.index', $data);
    }

    public function create()
    {
        $Supirs = Supir::orderBy('name', 'ASC')->get();
        $data['supirs'] = $Supirs;
        return view('admin.supir.create', $data);
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
            'name' => 'required|string|max:255', // Validasi untuk 'name'
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
            'role' => 'supir'
        ];

        if ($request->has('photo')) {
            $params1['photo'] = $this->simpanImage('supir', $request->file('photo'), $params1['name']);
        }

        $user = User::create($params2);
        if ($user) {
            $params1['user_id'] = $user->id;
            $supir = Supir::create($params1);
            if ($supir) {
                alert()->success('Success', 'Data Berhasil Disimpan');
            } else {
                $user->delete();
                alert()->error('Error', 'Data Gagal Disimpan');
            }
        }

        return redirect()->route('admin.supir.index');
    }

    public function edit($id)
    {
        $Supir = Supir::findOrFail(Crypt::decrypt($id));
        $data['data'] = $Supir;
        return view('admin.supir.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // Mengambil data admin dan user yang akan diperbarui
        $supir = Supir::findOrFail(Crypt::decrypt($id));
        $user = User::findOrFail($supir->user_id);

        // Validasi data supir
        $supirValidator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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

        if ($supirValidator->fails() || $userValidator->fails()) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($supirValidator->errors()->toArray(), $userValidator->errors()->toArray()))
                ->withInput();
        }

        // Mengupdate data supir
        $supirParams = $request->only(['name', 'photo']);
        if ($request->has('photo')) {
            $supirParams['photo'] = $this->simpanImage('supir', $request->file('photo'), $supirParams['name']);
        } else {
            $supirParams = $request->except('photo');
        }
        $supir->update($supirParams);

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

        if ($supir->update($supirParams) && $user->update($userParams)) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }
        return redirect()->route('admin.supir.index');
    }

    public function destroy($id)
    {
        try {
            $Supir = Supir::findOrFail(Crypt::decrypt($id));
            if ($Supir->delete()) {
                $user = User::findOrFail($Supir->user_id);
                $user->delete();
                alert()->success('Success', 'Data Berhasil Dihapus');
            } else {
                alert()->error('Error', 'Data Gagal Dihapus');
            }
        } catch (DecryptException $e) {
            alert()->error('Error', 'Data Tidak Ditemukan');
        } catch (ModelNotFoundException $e) {
            alert()->error('Error', 'Data Tidak Ditemukan');
        }

        return redirect()->route('admin.supir.index');
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
