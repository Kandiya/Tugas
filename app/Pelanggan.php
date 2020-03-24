<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table="pelanggan";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'nama', 'alamat', 'telp'
    ];
}
