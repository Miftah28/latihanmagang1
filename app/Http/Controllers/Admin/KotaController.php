<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDaerah;
use App\Models\Daerah;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{
    public function index()
    {
        $kotas = Kota::all();
        $data['kota'] = $kotas;
        return view('admin.kota.index', $data);
    }

    public function create()
    {
        $kotas = Kota::orderBy('nama_kota', 'ASC')->get();
        $data['kotas'] = $kotas;
        return view('admin.kota.create', $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kota' => 'required|string|max:255',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $params1 = $request->all();
        $kota = Kota::create($params1);
        if ($kota) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admin.kota.index');
    }

    public function edit($id)
    {
        $kota = kota::findOrFail(Crypt::decrypt($id));
        $data['data'] = $kota;
        return view('admin.kota.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $kotaParams = $request->all();

        $kota = kota::findOrFail(Crypt::decrypt($id));

        // Lakukan validasi data sebelum pembaruan
        $kotaValidator = Validator::make($kotaParams, [
            // Definisikan aturan validasi untuk atribut yang sesuai pada model kota
            'nama_kota' => 'required|string|max:255',
        ]);

        if ($kotaValidator->fails()) {
            // Kembalikan pesan kesalahan jika validasi gagal
            return redirect()->back()
                ->withErrors(array_merge($kotaValidator->errors()->toArray()))
                ->withInput();
        }
        if ($kota->update($kotaParams) ) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect()->route('admin.kota.index');
    }

    public function destroy($id)
    {
        $kota = kota::findOrFail(Crypt::decrypt($id));
        $daerah = Daerah::where('kota_id',$id);
        $kotanya = $kota->nama_kota;
        // dd($kotanya);
        $admindaerah = AdminDaerah::where('kota', $kotanya);
        if ($kota->delete() && $daerah->delete() && $admindaerah->delete()) {
            alert()->success('Success', 'Data Berhasil Dihapus');
        }
        return redirect()->route('admin.kota.index');
    }
}
