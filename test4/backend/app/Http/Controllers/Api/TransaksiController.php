<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

use App\Http\Requests\TransaksiRequest;
use App\Filters\TransaksiFilter;

use App\Http\Resources\GlobalResource;
use App\Http\Resources\TransaksiResource;
use App\Http\Resources\TransaksiCollection;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransaksiFilter $request)
    {
        $paginate = isset(request()->paginate) ? request()->paginate : null;
        return response()->json(new TransaksiCollection(Transaksi::select('*')->orderByDesc('id')->filter($request)->paginate($paginate)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransaksiRequest $request)
    {
        $record = Transaksi::saveData($request);
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
      return new TransaksiResource(Transaksi::findOrFail($id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransaksiRequest $request, $id)
    {
        $request['id'] = $id;
        $record = Transaksi::saveData($request);
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
      $item = Transaksi::destroy($id);
      return new GlobalResource('delete');
  }
}
