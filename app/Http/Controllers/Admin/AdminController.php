<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::all();
        $data['admin'] = $admin;
        return view('Admin.admin.index', $data);
    }

    public function create()
    {
        $admins = Admin::orderBy('name', 'ASC')->get();
        $data['admins'] = $admins;
        return view('admin.admin.create', $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmed'
            ],
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

        $user = User::create($params2);
        if ($user) {
            $params1['user_id'] = $user->id;
            $admin = Admin::create($params1);
            if ($admin) {
                alert()->success('Success', 'Data Berhasil Disimpan');
            } else {
                $user->delete();
                alert()->error('Error', 'Data Gagal Disimpan');
            }
        }

        return redirect()->route('admin.admin.index');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail(Crypt::decrypt($id));
        $data['data'] = $admin;
        return view('admin.admin.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $adminParams = $request->except('email', 'password');
        $userParams = [];

        if ($request->filled('password')) {
            $userParams['password'] = Hash::make($request->password);
        }

        $admin = Admin::findOrFail(Crypt::decrypt($id));
        $user = User::findOrFail($admin->user_id);

        // Lakukan validasi data sebelum pembaruan
        $adminValidator = Validator::make($adminParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model Admin
            'name' => 'required|string|max:255',
        ]);

        $userValidator = Validator::make($userParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model User
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmed'
            ],
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

        return redirect()->route('admin.admin.index');
    }

    public function destroy($id)
{
    try {
        $admin = Admin::findOrFail(Crypt::decrypt($id));
        if ($admin->delete()) {
            $user = User::findOrFail($admin->user_id);
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

    return redirect()->route('admin.admin.index');
}

}
