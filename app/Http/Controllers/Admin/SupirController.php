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
        $Supirs = Supir::orderBy('nama', 'ASC')->get();
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

        $user = User::create($params2);
        if ($user) {
            $params1['user_id'] = $user->id;
            $Supir = Supir::create($params1);
            if ($Supir) {
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
        $SupirParams = $request->except('email', 'password');
        $userParams = [];

        if ($request->filled('password')) {
            $userParams['password'] = Hash::make($request->password);
        }

        $Supir = Supir::findOrFail(Crypt::decrypt($id));
        $user = User::findOrFail($Supir->user_id);

        // Lakukan validasi data sebelum pembaruan
        $SupirValidator = Validator::make($SupirParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model Supir
            'nama' => 'required|string|max:255',
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

        if ($SupirValidator->fails() || $userValidator->fails()) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($SupirValidator->errors()->toArray(), $userValidator->errors()->toArray()))
                ->withInput();
        }

        // Lakukan pembaruan data
        if ($Supir->update($SupirParams) && $user->update($userParams)) {
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
}
