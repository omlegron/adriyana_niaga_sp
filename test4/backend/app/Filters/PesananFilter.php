<?php
namespace App\Filters;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Filters\QueryFilters;

class PesananFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }
  
    public function masterBarangId($term){
        return $this->builder->where('masterBarangId', $term);
    }

    public function orderId($term){
        return $this->builder->where('orderId', 'LIKE', '%'.$term.'%');
    }

    public function tanggal($term){
        return $this->builder->whereDate('tanggal', $term);
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
