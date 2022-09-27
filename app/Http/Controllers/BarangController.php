<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        if($request->ajax()){
            $dataBarang = Barang::select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'name',
                'jumlah'
            ]);
            return Datatables::of($dataBarang)->make(true);
        }
    }
    //export excel
    public function exportExcel(){
        return Excel::download(new BarangExport,'barang.xlsx');
    }
    //import excel
    public function importExcel(Request $request){
        Excel::import(new BarangImport, $request->file('import'));
        return back();
    }
    public function template(){
        $path = storage_path()."/excel_template/template_barang.xlsx";
        return response()->download($path);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        //
    }
}
