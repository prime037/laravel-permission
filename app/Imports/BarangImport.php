<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
class BarangImport implements ToModel, WithHeadingRow,WithCalculatedFormulas,WithChunkReading,ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Barang([       
            'name' => $row['nama_barang'],
            'jumlah' => $row['jumlah']
        ]);
    }
    public function chunkSize(): int
    {
        return 10;
    }
}
