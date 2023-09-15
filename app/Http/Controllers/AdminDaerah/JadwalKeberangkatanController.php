<?php

namespace App\Http\Controllers\AdminDaerah;

use App\Http\Controllers\Controller;
use App\Models\AdminDaerah;
use App\Models\Daerah;
use App\Models\JadwalPemberangkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalKeberangkatanController extends Controller
{
    public function index() 
    {
        $jadwal = JadwalPemberangkatan::where('admin_daerah_id',Auth::user()->admindaerah->id)->get();
        $data['jadwal'] = $jadwal;
        return view('Admin Daerah.jadwalpemberangkatan.index',$data);
    }
    public function create() 
    {
        $admindaerah = AdminDaerah::where('id', Auth::user()->admindaerah->id)->first();
        $daerah = Daerah::where('id',$admindaerah->daerah_id)->first();
        $data['pemberangkatan'] = $daerah;
        $daerahs = Daerah::all();
        $data['tujuans'] = $daerahs;
        // dd($daerah);

        return view('Admin Daerah.jadwalpemberangkatan.create',$data);
    }

    public function store() 
    {
        
    }
}
