<?php

namespace App\Http\Controllers\AdminDaerah;

use App\Http\Controllers\Controller;
use App\Models\AdminDaerah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index()
    {
        $penumpang = AdminDaerah::where('user_id', auth()->user()->id)->first();
        $data['data'] = $penumpang;
        return view('Admin Daerah.profile', $data);
    }

    public function update(Request $request)
    {
        $params = $request->all();

        $user = User::findOrFail(auth()->user()->id);
        $penumpang = AdminDaerah::where('user_id', auth()->user()->id)->first();

        $userUpdated = $user->update([
            'email' => $params['email'], // Update kolom email pada tabel users
        ]);

        $penumpangUpdated = $penumpang->update([
            'nama' => $params['name'], // Update kolom name pada tabel penumpangs
        ]);

        if ($userUpdated && $penumpangUpdated) {
            session()->flash('success', 'Data Berhasil Disimpan');
        } else {
            session()->flash('error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admindaerah.profile');
    }

    public function updatepassword(Request $request)
    {

        $request->validate([
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmed'
            ],
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);

        $user = User::findOrFail(auth()->id);
        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                Session::flash('error', 'Data Gagal Disimpan');
            }
        }
        return redirect()->route('Admin Daerah.profile');
    }
}
