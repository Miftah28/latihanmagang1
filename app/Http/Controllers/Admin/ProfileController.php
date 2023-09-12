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
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\File;

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
        $user = User::findOrFail(auth()->user()->id);
        $admin = Admin::where('user_id', auth()->user()->id)->first();

        $userValidator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // $adminValidator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        // ]);

        if ($userValidator->fails() ) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($userValidator->errors()->toArray()))
                ->withInput();
        }

        $adminParams = $request->only(['name', 'photo']);
        if ($request->has('photo')) {
            $adminParams['photo'] = $this->simpanImage('admin', $request->file('photo'), $adminParams['name']);
        } else {
            $adminParams = $request->except('photo');
        }
        $admin->update($adminParams);

        $user->update([
            'email' => $request->input('email'),
        ]);

        alert()->success('Success', 'Data Berhasil Disimpan');
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
