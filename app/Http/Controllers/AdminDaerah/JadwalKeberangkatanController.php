<?php

namespace App\Http\Controllers\AdminDaerah;

use App\Http\Controllers\Controller;
use App\Models\JadwalPemberangkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalKeberangkatanController extends Controller
{
    public function index() {
        $jadwal = JadwalPemberangkatan::where('admin_daerah_id',Auth::user()->admindaerah->id)->get();
        $data['jadwal'] = $jadwal;
        return view('Admin Daerah.jadwalpemberangkatan.index');
    }
}
