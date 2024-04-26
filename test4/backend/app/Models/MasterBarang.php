<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;
use App\Traits\Utilities;
use App\Filters\Filterable;

class MasterBarang extends Model
{
  use GenerateUuid;
  use Filterable;
  use Utilities;

  public $incrementing = false;
  protected $table = 'masterBarang';
  protected $keyType = 'string';
  protected $guarded = [];

  protected $fillable = [
    'id',
    'nama',
    'deskripsi',
    'status',
    'created_by',
    'updated_by',
  ];

}
