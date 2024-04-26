<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\MasterBarang;

use App\Http\Requests\PesananRequest;
use App\Filters\PesananFilter;

use App\Http\Resources\GlobalResource;
use App\Http\Resources\PesananResource;
use App\Http\Resources\PesananCollection;
use Carbon\Carbon;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PesananFilter $request)
    {
        $paginate = isset(request()->paginate) ? request()->paginate : null;
        return response()->json(new PesananCollection(Pesanan::select('*')->orderByDesc('id')->filter($request)->paginate($paginate)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PesananRequest $request)
    {
        $masterBarang = MasterBarang::where('nama', request()->namaBarang)->first();
        if(!$masterBarang){
          $masterBarang = MasterBarang::create([
            'nama' => request()->namaBarang
          ]);
        }
        $total = Pesanan::count() + 1;
        $tanggal = Carbon::now();
        $request['masterBarangId'] = $masterBarang->id;
        $request['orderId'] = 'ORD/'.$tanggal->format('m').'/'.$tanggal->format('Y').'/'.$total;
        
        $panjang = is_numeric(request()->barangPanjang) ? request()->barangPanjang : 0;
        $lebar = is_numeric(request()->barangLebar) ? request()->barangLebar : 0;         
        $tinggi = is_numeric(request()->barangTinggi) ? request()->barangTinggi : 0;         

        $request['barangKubikasi'] = $panjang * $lebar * $tinggi / 1000000;
        
        $barangKubikasi = ($request['barangKubikasi'] == 0) ? 1 : $request['barangKubikasi'];

        $request['total'] = $barangKubikasi * request()->barangJumlah;

        $record = Pesanan::saveData($request);
        
        $record->transaksiMany()->create([
          'jenisPembayaran' => request()->jenisPembayaran,
          'jenisBank' => request()->jenisBank,
          'tanggal' => request()->tanggal,
          'noTransaksi' => 'ORD/'.$tanggal->format('m').'/'.$tanggal->format('Y').'/'.$total.'-'.$record->id,
          'total' => $request['total'],
        ]);

        return new GlobalResource('create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return new PesananResource(Pesanan::findOrFail($id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PesananRequest $request, $id)
    {
        $request['id'] = $id;
        $record = Pesanan::saveData($request);
        return new GlobalResource('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $item = Pesanan::destroy($id);
      return new GlobalResource('delete');
  }
}
