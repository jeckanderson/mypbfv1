<?php

namespace App\Imports\MasterData;

use App\Models\Suplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel, WithChunkReading, WithHeadingRow
{
    public function model(array $row)
    {
        $supplier = Suplier::updateOrCreate([
            'id_perusahaan' => auth()->user()->id_perusahaan,
            'kode' => $row['kode'],
            'kode_e_report' => $row['kode_e_report']

        ], [
            'nama_suplier' => $row['nama_suplier'],
            'alamat' => $row['alamat'],
            'npwp' => $row['npwp'],
            'no_telepon' => $row['no_telepon']
        ]);
    }
    function chunkSize(): int
    {
        return 100;
    }
}
