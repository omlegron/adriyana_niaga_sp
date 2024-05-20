<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PesananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'masterBarangId' => $this->masterBarangId,
            'namaBarang' => ($this->masterBarang) ? $this->masterBarang->nama : '',
            'orderId' => $this->orderId,
            'tanggal' => $this->tanggal,
            'barangPanjang' => $this->barangPanjang,
            'barangLebar' => $this->barangLebar,
            'barangTinggi' => $this->barangTinggi,
            'barangJumlah' => $this->barangJumlah,
            'barangKubikasi' => $this->barangKubikasi,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'lokasiTujuan' => $this->lokasiTujuan,
            'lokasiJemput' => $this->lokasiJemput,
            'jenisPembayaran' => ($this->transaksi) ? $this->transaksi->jenisPembayaran : '',
            'jenisBank' => ($this->transaksi) ? $this->transaksi->jenisBank : '',
            'noTransaksi' => ($this->transaksi) ? $this->transaksi->noTransaksi : '',
            'total' => ($this->transaksi) ? moneyFormat($this->transaksi->total) : '',
            'tanggalTransaksi' => ($this->transaksi) ? $this->transaksi->tanggal : '',
            'statusPesanan' => ($this->transaksi) ? $this->transaksi->status : '',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
