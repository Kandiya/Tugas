<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table="petugas";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'nama_petugas', 'telp', 'level', 'username', 'password'
    ];
}
