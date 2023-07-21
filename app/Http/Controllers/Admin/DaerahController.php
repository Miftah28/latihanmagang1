<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DaerahController extends Controller
{

    public function create()
    {
        $daerahs = Daerah::orderBy('nama_daerah', 'ASC')->get();
        $data['daerahs'] = $daerahs;
        return view('admin.daerah.create', $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_daerah' => 'required|string|max:255',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $params1 = $request->all();
        $daerah = Daerah::create($params1);
        if ($daerah) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admin.admindaerah.index');
    }

    public function edit($id)
    {
        $daerah = daerah::findOrFail(Crypt::decrypt($id));
        $data['data'] = $daerah;
        return view('admin.daerah.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $daerahParams = $request->all();

        $daerah = daerah::findOrFail(Crypt::decrypt($id));

        // Lakukan validasi data sebelum pembaruan
        $daerahValidator = Validator::make($daerahParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model daerah
            'nama_daerah' => 'required|string|max:255',
        ]);

        if ($daerahValidator->fails()) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($daerahValidator->errors()->toArray()))
                ->withInput();
        }

        // Lakukan pembaruan data
        if ($daerah->update($daerahParams)) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admin.admindaerah.index');
    }

    public function destroy($id)
    {
        $daerah = daerah::findOrFail(Crypt::decrypt($id));
        if ($daerah->delete()) {
            alert()->success('Success', 'Data Berhasil Dihapus');
        }
        return redirect()->route('admin.admindaerah.index');
    }
}
