<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;
use App\Traits\Utilities;
use App\Filters\Filterable;

class Pesanan extends Model
{
  use GenerateUuid;
  use Filterable;
  use Utilities;

  public $incrementing = false;
  protected $table = 'pesanan';
  protected $keyType = 'string';
  protected $guarded = [];

  protected $fillable = [
    'id',
    'masterBarangId',
    'orderId',
    'tanggal',
    'total',
    'barangPanjang',
    'barangLebar',
    'barangTinggi',
    'barangJumlah',
    'barangKubikasi',
    'lokasiJemput',
    'lokasiTujuan',
    'deskripsi',
    'status',
    'created_by',
    'updated_by',
  ];

  public function masterBarang(){
    return $this->belongsTo('App\Models\MasterBarang', 'masterBarangId');
  }

  public function transaksiMany(){
    return $this->hasMany('App\Models\Transaksi', 'pesananId');
  }

  public function transaksi(){
    return $this->hasOne('App\Models\Transaksi', 'pesananId');
  }

}
