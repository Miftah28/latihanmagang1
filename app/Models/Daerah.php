<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;
    protected $fillable = [
        'kota_id',
        'nama_daerah',
    ];

    public function kota(){
        return $this->belongsTo('App\Models\Kota');
    }
}
