<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;
use App\Traits\Utilities;
use App\Filters\Filterable;

class Transaksi extends Model
{
  use GenerateUuid;
  use Filterable;
  use Utilities;

  public $incrementing = false;
  protected $table = 'transaksi';
  protected $keyType = 'string';
  protected $guarded = [];

  protected $fillable = [
    'id',
    'pesananId',
    'jenisPembayaran',
    'noTransaksi',
    'tanggal',
    'jenisBank',
    'biayaAdmin',
    'total',
    'status',
    'created_by',
    'updated_by',
  ];

  public function pesanan(){
    return $this->belongsTo('App\Models\Pesanan', 'pesananId');
  }

}
