<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    public function mahasiswas(){
        return $this -> hasMany('App\Models\Mahasiswa');
    }
}
