<?php

namespace App\Imports\MasterData;

use App\Models\Kelompok;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Model;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param Model $Model
     */
    public function __construct(protected $id)
    {
        $this->id = $id;
    }
    public function model(array $row)
    {
        $kelompok = Kelompok::updateOrCreate([
            'id_perusahaan' => $this->id,
            'kelompok' => $row['kelompok']
        ], [
            'id_perusahaan' => $this->id,
            'kelompok' => $row['kelompok']
        ]);
        $pelanggan = Pelanggan::updateOrCreate([
            'id_perusahaan' => $this->id,
            'kode' => $row['kode'],
            'kode_e_report' => $row['kode_e_report']
        ], [

            'tipe' => $row['tipe'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'nomor' => $row['nomor'],
            'npwp' => $row['npwp'],
            'batas_piutang' => $row['batas_piutang'],
            'batas_jt' => $row['batas_jt'],
            'apoteker' => $row['apoteker'],
            'no_sipa' => $row['no_sipa'],
            'no_sia' => $row['no_sia'],
            'kelompok' => $kelompok->id,
            'exp_date_sipa' => Carbon::instance(Date::excelToDateTimeObject($row['exp_date_sipa'])),
            'exp_date_sia' => Carbon::instance(Date::excelToDateTimeObject($row['exp_date_sia'])),
        ]);
    }
    function chunkSize(): int
    {
        return 100;
    }
}
