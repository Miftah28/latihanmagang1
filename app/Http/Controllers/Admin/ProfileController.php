<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function updatepassword()
    {
    }
}
