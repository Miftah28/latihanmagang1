<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Admin::where('user_id', auth()->user()->id)->first();
        $data['data'] = $admin;
        return view('admin.profile', $data);
    }

    public function update(Request $request)
    {
        $params = $request->all();

        // Ambil data pengguna dan admin berdasarkan user ID yang sedang login
        $user = User::findOrFail(auth()->user()->id);
        $admin = Admin::where('user_id', auth()->user()->id)->first();

        // Update data email pada tabel users
        $userUpdated = $user->update([
            'email' => $params['email'],
        ]);

        // Update data name pada tabel admins
        $adminUpdated = $admin->update([
            'name' => $params['name'],
        ]);

        if ($userUpdated && $adminUpdated) {
            // Jika update berhasil, tampilkan pesan sukses
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            // Jika update gagal, tampilkan pesan error
            alert()->error('Error', 'Data Gagal Disimpan');
        }

        // Redirect ke halaman profil pengguna
        return redirect()->route('admin.profile');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        // Jika input current_password diisi, maka lakukan pengecekan password lama
        if ($request->filled('current_password')) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));

                // Hapus input password dari request agar tidak menyebabkan validasi gagal di masa depan
                $request->offsetUnset('new_password');
                $request->offsetUnset('password_confirmation');
            } else {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
            }
        }

        if ($user->save()) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect()->route('admin.profile');
    }
}
