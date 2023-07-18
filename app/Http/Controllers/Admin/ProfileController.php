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

        $validator = Validator::make($params, [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(auth()->user()->id);
        $admin = Admin::where('user_id', auth()->user()->id)->first();

        $userUpdated = $user->update([
            'email' => $params['email'], // Update kolom email pada tabel users
        ]);

        $adminUpdated = $admin->update([
            'name' => $params['name'], // Update kolom name pada tabel admins
        ]);

        if ($userUpdated && $adminUpdated) {
            session()->flash('success', 'Data Berhasil Disimpan');
        } else {
            session()->flash('error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admin.profile');
    }

    public function updatepassword(Request $request)
    {
        $params = $request->all();

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
            } else {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
            }
        }

        $instance = Admin::where('user_id', auth()->user()->id)->first();
        if ($instance->update($params) && $user->save()) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect()->route('admin.profile');
    }
}
