<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBarang;

use App\Http\Requests\Master\MasterBarangRequest;
use App\Filters\Master\MasterBarangFilter;

use App\Http\Resources\GlobalResource;
use App\Http\Resources\MasterBarangResource;
use App\Http\Resources\MasterBarangCollection;

class MasterBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterBarangFilter $request)
    {
        $paginate = isset(request()->paginate) ? request()->paginate : null;
        return response()->json(new MasterBarangCollection(MasterBarang::select('*')->orderByDesc('id')->filter($request)->paginate($paginate)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterBarangRequest $request)
    {
        $record = MasterBarang::saveData($request);
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
      return new MasterBarangResource(MasterBarang::findOrFail($id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterBarangRequest $request, $id)
    {
        $request['id'] = $id;
        $record = MasterBarang::saveData($request);
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
      $item = MasterBarang::destroy($id);
      return new GlobalResource('delete');
  }
}
