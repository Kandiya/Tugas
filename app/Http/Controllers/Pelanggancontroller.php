<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use Illuminate\Support\Facades\Validator;
use Auth;

class Pelanggancontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=='admin'){

        $validator=Validator::make($req->all(),
            [
                'nama'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Pelanggan::create([
            'nama'=>$req->nama,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        if($simpan){
            $status='sukses';
            $message='Data Pelanggan Berhasil Ditambahkan';
        } else {
            $status='gagal';
            $message="Data Pelanggan Gagal Ditambahkan";
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
                'nama'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah=Pelanggan::where('id',$id)->update([
            'nama'=>$req->nama,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        if($ubah){
            $status='sukses';
            $message='Data Pelanggan Berhasil Diubah';
        } else {
            $status='gagal';
            $message="Data Pelanggan Gagal Diubah";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
    }
    public function destroy($id)
    {
        if(Auth::user()->level=='admin'){
        $hapus=Pelanggan::where('id',$id)->delete();
        if($hapus){
            $status='sukses';
            $message='Data Pelanggan Berhasil Dihapus';
        } else {
            $status='gagal';
            $message="Data Pelanggan Gagal Dihapus";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
    }
}
    public function tampil()
    {
        if(Auth::user()->level=='admin'){
       $data_pelanggan=Pelanggan::get();
       $count=$data_pelanggan->count();
       $arr_data=array();
       foreach($data_pelanggan as $dt_pg){
           $arr_data[]=array(
               'id'=>$dt_pg->id,
               'nama'=>$dt_pg->nama,
               'alamat'=>$dt_pg->alamat,
               'telp'=>$dt_pg->telp
           );
       }
       $status=1;
       return Response()->json(compact('status','count','arr_data'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
}
}