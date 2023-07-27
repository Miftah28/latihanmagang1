<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDaerah;
use App\Models\Daerah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminDaerahController extends Controller
{
    public function index()
    {
        $daerah = Daerah::all();
        $data['daerah'] = $daerah;
        $admin = AdminDaerah::all();
        $data['admin'] = $admin;
        return view('Admin.admindaerah.index', $data);
    }

    public function create()
    {
        $daerahs = Daerah::orderBy('nama_daerah', 'ASC')->get();
        $data['daerahs'] = $daerahs;
        $admins = AdminDaerah::orderBy('nama', 'ASC')->get();
        $data['admins'] = $admins;
        return view('admin.admindaerah.create', $data);
    }


    public function store(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required|min:8',
        //     'password' => [
        //         'required',
        //         'min:8',
        //         'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
        //         'confirmed'
        //     ],
        //     // Tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        // ]);

        // // if ($validator->fails()) {
        // //     return redirect()->back()->withErrors($validator)->withInput();
        // // }

        $params1 = $request->all();
        $params2 = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ];

        $user = User::create($params2);
        if ($user) {
            $params1['user_id'] = $user->id;
            $admin = AdminDaerah::create($params1);
            if ($admin) {
                alert()->success('Success', 'Data Berhasil Disimpan');
            } else {
                $user->delete();
                alert()->error('Error', 'Data Gagal Disimpan');
            }
        }

        return redirect()->route('admin.admindaerah.index');
    }

    public function edit($id)
    {
        $daerahs = Daerah::orderBy('nama_daerah', 'ASC')->get();
        $data['daerahs'] = $daerahs;
        $admin = AdminDaerah::findOrFail(Crypt::decrypt($id));
        $data['data'] = $admin;
        return view('admin.admindaerah.edit', $data);
    }

    public function update(Request $request, $id)
{
    $adminParams = $request->except('email', 'password',);
    $userParams = [];

    if ($request->filled('password')) {
        $userParams['password'] = Hash::make($request->password);
    }

    $admin = AdminDaerah::findOrFail(Crypt::decrypt($id));
    $user = User::findOrFail($admin->user_id);

    // Lakukan validasi data sebelum pembaruan
    $adminValidator = Validator::make($adminParams, [
        // Definisikan aturan validasi untuk atribut yang sesuai pada model Admin
        'name' => 'required|string|max:255',
        // Tambahkan aturan validasi lain sesuai kebutuhan
    ]);

    $userValidator = Validator::make($userParams, [
        // Definisikan aturan validasi untuk atribut yang sesuai pada model User
        'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
        'password' => [
            'nullable',
            'min:8',
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            'confirmed'
        ],
        // Tambahkan aturan validasi lain sesuai kebutuhan
    ]);

    if ($adminValidator->fails() || $userValidator->fails()) {
        // Kembalikan pesan kesalahan jika validasi gagal
        return redirect()->back()
            ->withErrors(array_merge($adminValidator->errors()->toArray(), $userValidator->errors()->toArray()))
            ->withInput();
    }

    // Lakukan pembaruan data
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
}
