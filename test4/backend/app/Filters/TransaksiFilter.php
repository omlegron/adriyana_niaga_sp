<?php
namespace App\Filters;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Filters\QueryFilters;

class TransaksiFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }
  
    public function pesananId($term){
        return $this->builder->where('pesananId', $term);
    }

    public function jenisPembayaran($term){
        return $this->builder->where('jenisPembayaran', $term);
    }

    public function noTransaksi($term){
        return $this->builder->where('noTransaksi', $term);
    }

    public function tanggal($term){
        return $this->builder->where('tanggal', $term);
    }

    public function jenisBank($term){
        return $this->builder->where('jenisBank', $term);
    }

    public function sort($array) {
        $myArray = explode(',', $array);
        foreach ($myArray as $value) {
              $this->builder->orderBy($value,'desc');
        }
    }

    public function sort_date($type = null) {
        return $this->builder->orderBy('created_at', (!$type || $type == 'asc') ? 'desc' : 'desc');
    }

    public function sort_name($type = null) {
        return $this->builder->orderBy('title', (!$type || $type == 'asc') ? 'asc' : 'desc');
    }
}
