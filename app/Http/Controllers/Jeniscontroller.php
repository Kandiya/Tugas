<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenis;
use Illuminate\Support\Facades\Validator;
use Auth;

class Jeniscontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=='admin'){
        $validator=Validator::make($req->all(),
            [
                'nama_jenis'=>'required',
                'hrg_per_kilo'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Jenis::create([
            'nama_jenis'=>$req->nama_jenis,
            'hrg_per_kilo'=>$req->hrg_per_kilo,
        ]);
        if($simpan){
            $status='sukses';
            $message='Data Jenis Berhasil Ditambahkan';
        } else {
            $status='gagal';
            $message="Data Jenis Gagal Ditambahkan";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
    }
}
    public function update($id, Request $req)
       {
        if(Auth::user()->level=='admin'){
        $validator=Validator::make($req->all(),
            [
                'nama_jenis'=>'required',
                'hrg_per_kilo'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah=Jenis::where('id',$id)->update([
            'nama_jenis'=>$req->nama_jenis,
            'hrg_per_kilo'=>$req->hrg_per_kilo,
        ]);
        if($ubah){
            $status='sukses';
            $message='Data Jenis Berhasil Diubah';
        } else {
            $status='gagal';
            $message="Data Jenis Gagal Diubah";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
       }
    public function destroy($id)
    {
        if(Auth::user()->level=='admin'){
        $hapus=Jenis::where('id',$id)->delete();
        if($hapus){
            $status='sukses';
            $message='Data Jenis Berhasil Dihapus';
        } else {
            $status='gagal';
            $message="Data Jenis Gagal Dihapus";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
    }
    public function tampil()
    {
        if(Auth::user()->level=='admin'){ 
       $data_jenis=Jenis::get();
       $count=$data_jenis->count();
       $arr_data=array();
       foreach($data_jenis as $dt_jn){
           $arr_data[]=array(
               'id'=>$dt_jn->id,
               'nama_jenis'=>$dt_jn->nama_jenis,
               'hrg_per_kilo'=>$dt_jn->hrg_per_kilo,
           );
       }
       $status=1;
       return Response()->json(compact('status','count','arr_data'));
    }else{
        return Response()->json($message='Anda bukan Admin');
    }
}
}