<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Reportcontroller extends Controller
{
    public function report($tgl_awal, $tgl_akhir){
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
    }
}
