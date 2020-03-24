<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use App\Petugas;
use App\Transaksi;
use App\Jenis;
use App\Detail;
use JWTAuth;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;


class Transaksicontroller extends Controller
{
  public function report($tgl_awal, $tgl_akhir){
    if(Auth::user()->level=='petugas'){
      $transaksi=DB::table('transaksi')
      ->join('pelanggan','pelanggan.id','=','transaksi.id_pelanggan')
      ->join('petugas','petugas.id','=','transaksi.id_petugas')
      ->where('transaksi.tgl_transaksi', '>=', $tgl_awal)
      ->where('transaksi.tgl_transaksi', '<=', $tgl_akhir)
      ->select('transaksi.id', 'tgl_transaksi', 'nama', 'alamat', 'pelanggan.telp', 'tgl_selesai')
      ->get();

      $data=array(); $no=0;
      foreach ($transaksi as $tr){
        $data[$no]['tgl_transaksi'] = $tr->tgl_transaksi;
        $data[$no]['nama'] = $tr->nama;
        $data[$no]['alamat'] = $tr->alamat;
        $data[$no]['telp'] = $tr->telp;
        $data[$no]['tgl_selesai'] = $tr->tgl_selesai; 

        $grand=DB::table('detail')->where('id_trans', $tr->id)->groupBy('id_trans')
        ->select(DB::raw('sum(subtotal) as grand_total'))->first();

        $data[$no]['grand'] = $grand->grand_total;
        $detail=DB::table('detail')->join('jenis_cuci', 'jenis_cuci.id', '=', 'detail.id_jenis')
        ->where('id_trans', $tr->id)->select('jenis_cuci.nama_jenis', 'jenis_cuci.hrg_per_kilo', 'detail.qty', 'detail.subtotal')->get();

        $data[$no]['detail'] = $detail;
      }///
      return response()->json(compact("data"));
    }else{
      return Response()->json($message='Anda bukan Petugas');
    }
       
  }
      
    

    public function store(Request $request){
      if(Auth::user()->level=='petugas'){
      $validator=Validator::make($request->all(),
        [
          'id_pelanggan'=>'required',
          'id_petugas'=>'required',
          'tgl_transaksi'=>'required',
          'tgl_selesai'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Transaksi::create([
        'id_pelanggan'=>$request->id_pelanggan,
        'id_petugas'=>$request->id_petugas,
        'tgl_transaksi'=>$request->tgl_transaksi,
        'tgl_kembali'=>$request->tgl_kembali
      ]);
      $status=1;
      $message="Transaksi Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else{
        return Response()->json($message='Anda bukan Petugas');
      }
    
  }
    }
    public function update($id,Request $request){
      if(Auth::user()->level=='petugas'){
      $validator=Validator::make($request->all(),
        [
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required',
            'tgl_selesai'=>'required'
        ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }

    $ubah=Transaksi::where('id',$id)->update([
        'id_pelanggan'=>$request->id_pelanggan,
        'id_petugas'=>$request->id_petugas,
        'tgl_transaksi'=>$request->tgl_transaksi,
        'tgl_selesai'=>$request->tgl_selesai
    ]);
    $status=1;
    $message="Transaksi Berhasil Diubah";
    if($ubah){
      return Response()->json(compact('status','message'));
    }else{
      return Response()->json($message='Anda bukan Petugas');
    }
      }
    }
  public function destroy($id){
    if(Auth::user()->level=='petugas'){
    $hapus=Transaksi::where('id',$id)->delete();
    $status=1;
    $message="Transaksi Berhasil Dihapus";
    if($hapus){
      return Response()->json(compact('status','message'));
    }else{
      return Response()->json($message='Anda bukan Petugas');
    }
  
}


  }



  //detail_pinjam

  public function simpan(Request $request){
    if(Auth::user()->level=='petugas'){
    $validator=Validator::make($request->all(),
      [
        'id_trans'=>'required',
        'id_jenis'=>'required',
        'qty'=>'required'
      ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }

    $harga = Jenis::where('id', $request->id_jenis)->first();
    $subtotal = $harga->hrg_per_kilo * $request->qty;

    $simpan=Detail::create([
      'id_trans'=>$request->id_trans,
      'id_jenis'=>$request->id_jenis,
      'subtotal'=>$subtotal,
      'qty' =>$request->qty
    ]);
    $status=1;
    $message="Detail Transaksi Berhasil Ditambahkan";
    if($simpan){
      return Response()->json(compact('status','message'));
  }else{
    return Response()->json($message='Anda bukan Petugas');
  }
  }
  }
  public function ubah($id,Request $request){
    if(Auth::user()->level=='petugas'){
    $validator=Validator::make($request->all(),
      [
        'id_trans'=>'required',
        'id_jenis '=>'required',
        'subtotal'=>'required'
      ]
  );

  if($validator->fails()){
    return Response()->json($validator->errors());
  }

  $ubah=Detail::where('id',$id)->update([
      'id_trans'=>$request->id_trans,
      'id_jenis'=>$request->id_jenis,
      'subtotal'=>$request->subtotal
  ]);
  $status=1;
  $message="Detail Transaksi Berhasil Diubah";
  if($ubah){
    return Response()->json(compact('status','message'));
  }else{
    return Response()->json($message='Anda bukan Petugas');
  }
    }
  }

public function hapus($id){
  if(Auth::user()->level=='petugas'){
  $hapus=Detail::where('id',$id)->delete();
  $status=1;
  $message="Detail Transaksi Berhasil Dihapus";
  if($hapus){
    return Response()->json(compact('status','message'));
  }else{
    return Response()->json($message='Anda bukan Petugas');
  }
  }
}
public function tampil_detail(){
  if(Auth::user()->level=='petugas'){
  $detail=DB::table(detail)
  ->join('transaksi','transaksi.id', '=', 'detail.id_trans')
  ->join('jenis_cuci', 'jenis_cuci.id', '=', 'detail.id_jenis')
  ->select('jenis_cuci.nama_jenis', 'jenis_cuci.hrg_per_kilo', 'detail.qty', 'detail.subtotal')
  ->get();
  $count_detail->count();
  return response()->json(compact('detail', 'count'));


  
  }else{
    return Response()->json($message='Anda bukan Petugas');
}
}
}