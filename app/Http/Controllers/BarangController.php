<?php

namespace App\Http\Controllers;

use App\Events\BarangStored;
use DataTables;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use App\Jobs\SendEmailToUserWithJob;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Elegant\Sanitizer\Sanitizer;

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
                'jumlah',
                'id'
            ]);
        }
        return Datatables::of($dataBarang)->make(true);
    }
    //restore barang
    public function show_restore(){
        $restore = Barang::onlyTrashed()->get();
        return view('content.restore_barang',['data' => $restore]);
    }
    public function restore($id){
        $restore = Barang::onlyTrashed()->where('id',$id);
    	$restore->restore();
    	return redirect('/home')->with('restore','restore');
    }
    //export excel
    public function exportExcel(){
        return Excel::download(new BarangExport,'barang.xlsx');
    }
    //import excel
    public function importExcel(Request $request){
        Excel::queueImport(new BarangImport, $request->file('import'));
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
        $validated = $request;
        $validated = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'jumlah' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
        if ($validated->fails()) {
            return  response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validated->errors())]);;
        } 
        $data = [
            "name" => $request->name,
            "jumlah" => $request->jumlah
        ];
        $filters = [
            'name' => 'trim|empty_string_to_null|capitalize|escape',
            'jumlah' => 'trim|empty_string_to_null|escape',
        ];
        $newData = \Sanitizer::make($data, $filters)->sanitize();
        // $queue = [
        //     'name' => $request->name,
        //     'jumlah'  => $request->jumlah
        // ];
        // event(new BarangStored($queue));
        // SendEmailToUserWithJob::dispatch($queue);
        return Barang::create([
            'name' => $newData['name'],
            'jumlah' => $newData['jumlah']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang,Request $request)
    {
        //
        $data = Barang::findOrFail($request->id);
        return response()->json(['data' => $data]);
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
        $edit_barang = Barang::findOrFail($request->id);
        $validated = $request;
        $validated = Validator::make($request->all(),[
            'edit_name' => 'required|min:4',
            'edit_jumlah' => 'required'
        ]);
        if ($validated->fails()) {
            return  response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validated->errors())]);
        } 
        
        return $edit_barang->update([
            'name' => $request->edit_name,
            'jumlah' => $request->edit_jumlah
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang, Request $request)
    {
        //
        $barang = Barang::findOrFail($request->id);
        $barang->delete();
    }
}
