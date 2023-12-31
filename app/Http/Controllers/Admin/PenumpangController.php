<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penumpang;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenumpangController extends Controller
{
    public function index()
    {
        $Penumpang = Penumpang::all();
        $data['Penumpang'] = $Penumpang;
        return view('admin.penumpang.index', $data);
    }

    public function create()
    {
        $Penumpangs = Penumpang::orderBy('name', 'ASC')->get();
        $data['Penumpangs'] = $Penumpangs;
        return view('admin.penumpang.create', $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
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
            'role' => 'penumpang'
        ];

        $user = User::create($params2);
        if ($user) {
            $params1['user_id'] = $user->id;
            $Penumpang = Penumpang::create($params1);
            if ($Penumpang) {
                alert()->success('Success', 'Data Berhasil Disimpan');
            } else {
                $user->delete();
                alert()->error('Error', 'Data Gagal Disimpan');
            }
        }

        return redirect()->route('admin.penumpang.index');
    }

    public function edit($id)
    {
        $Penumpang = Penumpang::findOrFail(Crypt::decrypt($id));
        $data['data'] = $Penumpang;
        return view('admin.penumpang.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $PenumpangParams = $request->except('email', 'password');
        $userParams = [];

        if ($request->filled('password')) {
            $userParams['password'] = Hash::make($request->password);
        }

        $Penumpang = Penumpang::findOrFail(Crypt::decrypt($id));
        $user = User::findOrFail($Penumpang->user_id);

        // Lakukan validasi data sebelum pembaruan
        $PenumpangValidator = Validator::make($PenumpangParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model Penumpang
            'name' => 'required|string|max:255',
        ]);

        $userValidator = Validator::make($userParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model User
            'email' => 'nullable|email|unique:users',
            'password' => [
                'nullable',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmed'
            ],
        ]);

        if ($PenumpangValidator->fails() || $userValidator->fails()) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($PenumpangValidator->errors()->toArray(), $userValidator->errors()->toArray()))
                ->withInput();
        }

        // Lakukan pembaruan data
        if ($Penumpang->update($PenumpangParams) && $user->update($userParams)) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admin.penumpang.index');
    }

    public function destroy($id)
    {
        try {
            $Penumpang = Penumpang::findOrFail(Crypt::decrypt($id));
            if ($Penumpang->delete()) {
                $user = User::findOrFail($Penumpang->user_id);
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

        return redirect()->route('admin.penumpang.index');
    }
    
}
