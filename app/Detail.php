<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table="detail";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable=[
        'id_trans', 'id_jenis', 'subtotal', 'qty'
    ];
}
