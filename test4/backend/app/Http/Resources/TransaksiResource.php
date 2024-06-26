<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TransaksiResource extends JsonResource
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
            'pesananId' => $this->pesananId,
            'jenisPembayaran' => $this->jenisPembayaran,
            'noTransaksi' => $this->noTransaksi,
            'tanggal' => $this->tanggal,
            'jenisBank' => $this->jenisBank,
            'biayaAdmin' => $this->biayaAdmin,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }
}
