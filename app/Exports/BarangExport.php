<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $test = collect([["test","test","test"],["test",'test',"test"]]);
        $items = Barang::all();
        $test = [];
        $i = 0;
        foreach($items as $item ){
            $i++;
            $test[] = [$i,$item["name"],$item["jumlah"]];
        };
        return collect($test);
    }
    public function headings(): array
    {
        return ["Nomor", "Nama Barang", "Jumlah"];
    }
}
