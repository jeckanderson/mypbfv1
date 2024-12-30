<?php

namespace App\Imports;

use App\Models\AkunAkutansi;
use App\Models\Jurnal;
use App\Models\JurnalTetap;
use App\Models\PiutangAwal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;
use App\Models\Pelanggan;
use App\Models\PiutangPengguna;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PiutangAwalImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        try {
            // Validate if the required fields are present
            if (empty($row['no_reff']) || empty($row['no_faktur']) || empty($row['pelanggan']) || empty($row['tgl_jth_tempo']) || empty($row['jmlh_piutang']) || empty($row['jns_piutang'])) {
                throw ValidationException::withMessages(['import_error' => 'Some required fields are missing.']);
            }

            // Log input row for debugging
            Log::info('Processing row:', $row);

            // Convert Excel date to PHP DateTime object
            $tglJthTempo = is_numeric($row['tgl_jth_tempo'])
                ? Date::excelToDateTimeObject($row['tgl_jth_tempo'])->format('Y-m-d')
                : Carbon::createFromFormat('d/m/y', $row['tgl_jth_tempo'])->format('Y-m-d');

            $pelanggan = Pelanggan::where('kode', $row['pelanggan'])->first();
            if (!$pelanggan) {
                throw ValidationException::withMessages(['import_error' => 'Pelanggan not found: ' . $row['pelanggan']]);
            }

            $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();
            if (!$profile) {
                throw ValidationException::withMessages(['import_error' => 'Profile not found for id_perusahaan: ' . Auth::user()->id_perusahaan]);
            }

            // Create PiutangAwal instance
            $piutangAwal = new PiutangAwal([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $row['no_reff'],
                'no_faktur' => $row['no_faktur'],
                'tgl_faktur' => date("Y-m-d", strtotime($profile->tgl_neraca_awal)),
                'pelanggan' => $pelanggan->id,
                'tgl_jth_tempo' => $tglJthTempo,
                'jmlh_piutang' => $row['jmlh_piutang'],
                'jns_piutang' => $row['jns_piutang'],
            ]);

            $piutangAwal->save();
            // Log after save
            Log::info('Saved PiutangAwal:', $piutangAwal->toArray());

            // Create PiutangPengguna
            PiutangPengguna::create([
                'id_perusahaan' => $piutangAwal->id_perusahaan,
                'id_penjualan' => $piutangAwal->id,
                'sumber' => 'piutang awal',
                'id_pelanggan' => $piutangAwal->pelanggan,
                'nominal_bayar' => 0,
                'total_hutang' => $piutangAwal->jmlh_piutang ?? 0,
                'sisa_hutang' => $piutangAwal->jmlh_piutang ?? 0,
            ]);

            // Update or create JurnalTetap entries
            $jurnalPiutang = JurnalTetap::where('id_akun', 1)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            if ($jurnalPiutang) {
                $jurnalPiutang->update([
                    'saldo' => $jurnalPiutang->saldo + str_replace('.', '', $piutangAwal->jmlh_piutang),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 1,
                    'saldo' => str_replace('.', '', $piutangAwal->jmlh_piutang)
                ]);
            }
            if ($jurnalModal) {
                $jurnalModal->update([
                    'saldo' => $jurnalModal->saldo + str_replace('.', '', $piutangAwal->jmlh_piutang),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 8,
                    'saldo' => str_replace('.', '', ($piutangAwal->jmlh_piutang))
                ]);
            }

            // Create Jurnal entries
            Jurnal::create([
                'id_perusahaan' => $piutangAwal->id_perusahaan,
                'no_reff' => $piutangAwal->no_reff,
                'kode_akun' => AkunAkutansi::find(1)->kode,
                'id_sumber' => $piutangAwal->id,
                'sumber' => 'Piutang Awal',
                'keterangan' => 'Piutang Awal',
                'debet' => $piutangAwal->jmlh_piutang,
            ]);

            Jurnal::create([
                'id_perusahaan' => $piutangAwal->id_perusahaan,
                'no_reff' => $piutangAwal->no_reff,
                'kode_akun' => AkunAkutansi::find(8)->kode,
                'id_sumber' => $piutangAwal->id,
                'sumber' => 'Piutang Awal',
                'keterangan' => 'Piutang Awal',
                'kredit' => $piutangAwal->jmlh_piutang,
            ]);

            // Log after creating Jurnal entries
            Log::info('Created Jurnal entries for PiutangAwal');
        } catch (\Exception $e) {
            // Handle error if any
            Log::error('Error importing data: ' . $e->getMessage());
            throw ValidationException::withMessages(['import_error' => 'Error importing data: ' . $e->getMessage()]);
        }
    }

    public function rules(): array
    {
        return [
            'no_reff' => ['required'],
            'no_faktur' => ['required'],
            'pelanggan' => ['required'],
            'tgl_jth_tempo' => ['required'],
            'jmlh_piutang' => ['required'],
            'jns_piutang' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'no_reff.required' => 'Kolom no_reff wajib diisi.',
            'no_faktur.required' => 'Kolom no_faktur wajib diisi.',
            'pelanggan.required' => 'Kolom pelanggan wajib diisi.',
            'tgl_jth_tempo.required' => 'Kolom tgl_jth_tempo wajib diisi.',
            'jmlh_piutang.required' => 'Kolom jmlh_piutang wajib diisi.',
            'jns_piutang.required' => 'Kolom jns_piutang wajib diisi.',
        ];
    }
}
