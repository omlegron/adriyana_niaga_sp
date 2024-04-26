<?php
namespace App\Traits;
use Webpatser\Uuid\Uuid;
use Facades\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
/**
 *
 */
trait GenerateUuid
{

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->keyType = 'string';
      $model->incrementing = false;
      if(Schema::hasColumn($model->getTable(), 'created_by')){
          $model->created_by = (Auth::check()) ? Auth::user()->id : null;
      }
      $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: (string) Str::orderedUuid();
    });

    static::updating(function ($model) {
        if(Schema::hasColumn($model->getTable(), 'updated_by')){
          $model->updated_by = (Auth::check()) ? Auth::user()->id : null;
      }
    });
  }

  public function getIncrementing()
  {
    return false;
  }

  public function getKeyType()
  {
    return 'string';
  }

}
