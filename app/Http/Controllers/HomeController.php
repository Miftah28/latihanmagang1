<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            return view('Admin.home');
        } else if(auth()->user()->role == 'admindaerah') {
            return view('Admin Daerah.home');
        } else if(auth()->user()->role == 'supir') {
            return view('supir.home');
        } else if(auth()->user()->role == 'penumpang') {
            return view('layouts.index');
        }
    }
}
