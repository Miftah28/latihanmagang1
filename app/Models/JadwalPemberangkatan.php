<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPemberangkatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_daerah_id',
        'daerah_id',
        'keberangkatan',
        'tujuan',
        'tanggal_keberangkatan',
        'waktu',
        'alamat',
        'phone',
    ];
}
