<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDaerah extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kota_id',
        'daerah_id',
        'name',
        'photo',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function kota(){
        return $this->belongsTo('App\Models\Kota');
    }
    public function daerah(){
        return $this->belongsTo('App\Models\Daerah');
    }
}
