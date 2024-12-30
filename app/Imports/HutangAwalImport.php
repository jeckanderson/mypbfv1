<?php

namespace App\Imports;

use App\Models\HutangAwal;
use App\Models\Profile;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;
use App\Models\AkunAkutansi;
use App\Models\Jurnal;
use App\Models\JurnalTetap;

class HutangAwalImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        try {
            // Validate if the required fields are present
            if (empty($row['no_reff']) || empty($row['no_faktur']) || empty($row['supplier']) || empty($row['tgl_jth_tempo']) || empty($row['jmlh_hutang']) || empty($row['jns_hutang'])) {
                throw new ValidationException('Some required fields are missing.');
            }

            // Convert Excel date to PHP DateTime object
            $tglJthTempo = is_numeric($row['tgl_jth_tempo'])
                ? Date::excelToDateTimeObject($row['tgl_jth_tempo'])->format('Y-m-d')
                : \Carbon\Carbon::createFromFormat('d/m/y', $row['tgl_jth_tempo'])->format('d-m-d');

            $supplier = Suplier::where('kode', $row['supplier'])->first();
            if (!$supplier) {
                throw new ValidationException('Supplier not found: ' . $row['supplier']);
            }

            $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();
            if (!$profile) {
                throw new ValidationException('Profile not found for id_perusahaan: ' . Auth::user()->id_perusahaan);
            }

            // Create HutangAwal instance
            $hutangAwal = new HutangAwal([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $row['no_reff'],
                'no_faktur' => $row['no_faktur'],
                'tgl_faktur' => date("Y-m-d", strtotime($profile->tgl_neraca_awal)),
                'supplier' => $supplier->id,
                'tgl_jth_tempo' => $tglJthTempo,
                'jmlh_hutang' => $row['jmlh_hutang'],
                'jns_hutang' => $row['jns_hutang'],
            ]);

            // Simpan data HutangAwal
            $hutangAwal->save();

            // Proses jurnal untuk HutangAwal yang baru dibuat
            $jurnalHutang = JurnalTetap::where('id_akun', 6)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();

            // Pastikan ada penyesuaian yang benar untuk saldo jurnal
            if ($jurnalHutang) {
                $jurnalHutang->update([
                    'saldo' => $jurnalHutang->saldo + $hutangAwal->jmlh_hutang,
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 6,
                    'saldo' => $hutangAwal->jmlh_hutang,
                ]);
            }

            if ($jurnalModal) {
                $jurnalModal->update([
                    'saldo' => $jurnalModal->saldo - $hutangAwal->jmlh_hutang,
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 8,
                    'saldo' => - ($hutangAwal->jmlh_hutang),
                ]);
            }

            // Buat entri jurnal untuk transaksi Hutang Awal
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $row['no_reff'], // Sesuaikan dengan data yang sesuai
                'kode_akun' => AkunAkutansi::find(6)->kode, // Sesuaikan dengan akun yang sesuai
                'id_sumber' => $hutangAwal->id,
                'sumber' => 'Hutang Awal',
                'keterangan' => 'Hutang Awal',
                'kredit' => $hutangAwal->jmlh_hutang,
            ]);

            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $row['no_reff'], // Sesuaikan dengan data yang sesuai
                'kode_akun' => AkunAkutansi::find(8)->kode, // Sesuaikan dengan akun yang sesuai
                'id_sumber' => $hutangAwal->id,
                'sumber' => 'Hutang Awal',
                'keterangan' => 'Hutang Awal',
                'debet' => $hutangAwal->jmlh_hutang,
            ]);
        } catch (\Exception $e) {
            // Handle error if any
            throw ValidationException::withMessages(['import_error' => 'Error importing data: ' . $e->getMessage()]);
        }
    }

    public function rules(): array
    {
        return [
            'no_reff' => ['required'],
            'no_faktur' => ['required'],
            'supplier' => ['required'],
            'tgl_jth_tempo' => ['required'],
            'jmlh_hutang' => ['required'],
            'jns_hutang' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'no_reff.required' => 'Kolom no_reff wajib diisi.',
            'no_faktur.required' => 'Kolom no_faktur wajib diisi.',
            'supplier.required' => 'Kolom supplier wajib diisi.',
            'tgl_jth_tempo.required' => 'Kolom tgl_jth_tempo wajib diisi.',
            'jmlh_hutang.required' => 'Kolom jmlh_hutang wajib diisi.',
            'jns_hutang.required' => 'Kolom jns_hutang wajib diisi.',
        ];
    }
}
