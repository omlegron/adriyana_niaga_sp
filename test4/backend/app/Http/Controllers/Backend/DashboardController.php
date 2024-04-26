<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Carbon\Carbon;


class DashboardController extends Controller
{
    public $breadcrumbs = [
        ['link' => "/peminjaman", 'name' => "Peminjaman & Pengembalian Buku"], 
    ];
    
    public function __construct()
    {
        // $this->middleware('web');
        $this->route = 'peminjaman';
        $this->api = Config('app.urlApi');
    }
    
    public function index()
    {
        
        $dataBuku = getApi('masterBuku')->rows; 
        $dataMhs = getApi('masterMahasiswa')->rows; 
        return view('backend.dashboard.index',[
            'breadcrumbs' => $this->breadcrumbs,
            'title' => 'Peminjaman & Pengembalian Buku',
            'route' => $this->route,
            'dataBuku' => $dataBuku,
            'dataMhs' => $dataMhs
        ]);
    }

    public function list(Request $request)
    {
        $req = [];
        if(request()->nim){
            $req['nim'] = request()->nim;
        }
        
        if(request()->mahasiswaId){
            $req['mahasiswaId'] = request()->mahasiswaId;
        }
        
        if(request()->kode){
            $req['kode'] = request()->kode;
        }
        
        if(request()->bukuId){
            $req['bukuId'] = request()->bukuId;
        }
        
        if(request()->tanggalPinjam){
            $req['tanggalPinjam'] = request()->tanggalPinjam;
        }
        
        if(request()->tanggalKembali){
            $req['tanggalKembali'] = request()->tanggalKembali;
        }
        
        if(request()->lamaPinjam){
            $req['lamaPinjam'] = request()->lamaPinjam;
        }
        
        if(request()->status){
            $req['status'] = request()->status;
        }
        $data = getApi('pinjamBuku', $req)->rows; 

        return datatables()->of($data)
        ->addColumn('numSelect', function ($data) use ($request) {
            $button = '';
            $button .= makeButton([
                'type' => 'deleteAll',
                'value' => $data->uuid
            ]);
            return $button;
        })
        ->addColumn('nim', function ($data) use ($request) {
            $button = '';
            $button .= ($data->masterMahasiswa) ? $data->masterMahasiswa->nim : '-';
            return $button;
        })
        ->addColumn('name', function ($data) use ($request) {
            $button = '';
            $button .= ($data->masterMahasiswa) ? $data->masterMahasiswa->name : '-';
            return $button;
        })
        ->addColumn('kode', function ($data) use ($request) {
            $button = '';
            $button .= ($data->masterBuku) ? $data->masterBuku->kode : '-';
            return $button;
        })
        ->addColumn('namaBuku', function ($data) use ($request) {
            $button = '';
            $button .= ($data->masterBuku) ? $data->masterBuku->name : '-';
            return $button;
        })
        ->addColumn('status', function ($data) use ($request) {
            $button = '';
            $button .= ($data->status == false) ? 'Dipinjam' : 'Dikembalikan';
            return $button;
        })
        ->addColumn('action', function($data){
        $buttons = "";

            $buttons .= makeButton([
            'type' => 'modal',
            'url'   => ''.$this->route.'/'.$data->uuid.'/edit'
            ]);

            $buttons .= makeButton([
            'type' => 'delete',
            'id'   => $data->uuid
            ]);
        return $buttons;
        })
        ->rawColumns(['action','numSelect'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        $dataBuku = getApi('masterBuku')->rows; 
        $dataMhs = getApi('masterMahasiswa')->rows; 
        return view('backend.dashboard.create',[
            'route' => $this->route,
            'api' => $this->api.'pinjamBuku',
            'dataBuku' => $dataBuku,
            'dataMhs' => $dataMhs
        ]);
    }

    public function edit($id)
    {
      $record = getApi('pinjamBuku/'.$id); 
      $dataBuku = getApi('masterBuku')->rows; 
      $dataMhs = getApi('masterMahasiswa')->rows; 
      return view('backend.dashboard.edit',[
        'route' => $this->route,
        'record' => $record,
        'api' => $this->api.'pinjamBuku/'.$id,
        'dataBuku' => $dataBuku,
        'dataMhs' => $dataMhs
      ]);
    }
}
