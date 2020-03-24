<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table="jenis_cuci";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'nama_jenis', 'hrg_per_kilo'
    ];
}
