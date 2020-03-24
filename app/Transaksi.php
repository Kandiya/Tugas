<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table="transaksi";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'id_pelanggan', 'id_petugas', 'tgl_transaksi', 'tgl_selesai'
    ];
}
