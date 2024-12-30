<?php

namespace App\Http\Controllers;

use App\Livewire\KeuanganAkutansi\MutasiSaldo\MutasiSaldo;
use App\Models\JurnalAkun;
use App\Models\Kontrabon;
use App\Models\MutasiSaldoAkun;
use App\Models\PembayaranHutang;
use App\Models\PembayaranPiutang;
use App\Models\Profile;
use App\Models\TagihanPelanggan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_kontra_bon'])->only('kontrabon');
        $this->middleware(['permission:tambah_kontra_bon'])->only('tambahKontrabon');
        $this->middleware(['permission:aksi_kontra_bon'])->only('editKontrabon');
        $this->middleware(['permission:akses_tagihan_pelanggan'])->only('tagihanPelanggan');
        $this->middleware(['permission:tambah_tagihan_pelanggan'])->only('tambahTagihanPelanggan');
        $this->middleware(['permission:aksi_tagihan_pelanggan'])->only('editTagihanPelanggan');
        $this->middleware(['permission:akses_pembayaran_hutang'])->only('pembayaranHutang');
        $this->middleware(['permission:tambah_pembayaran_hutang'])->only('tambahPembayaranHutang');
        $this->middleware(['permission:aksi_pembayaran_hutang'])->only('lihatPembayaranHutang');
        $this->middleware(['permission:akses_pembayaran_piutang'])->only('pembayaranPiutang');
        $this->middleware(['permission:tambah_pembayaran_piutang'])->only('tambahPembayaranPiutang');
        $this->middleware(['permission:aksi_pembayaran_piutang'])->only('editPembayaranPiutang');
        $this->middleware(['permission:akses_mutasi_saldo'])->only('mutasiSaldo');
        $this->middleware(['permission:akses_jurnal_akun'])->only('jurnalAkun');
        $this->middleware(['permission:tambah_jurnal_akun'])->only('tambahJurnalAkun');
    }


    public function kontrabon()
    {
        return view('pages.keuangan-akuntansi.keuangan.kontrabon.kontrabon', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function cetakKontrabon($id)
    {
        $kontrabon = Kontrabon::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.kontrabon', [
            'kontrabon' => $kontrabon,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-kontrabon.pdf');
    }

    public function cetakNotaHutang($id)
    {
        $pembayaran = PembayaranHutang::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.nota_pembayaran_hutang', [
            'bayar' => $pembayaran,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-tagihan_pelanggan.pdf');
    }

    public function cetakTagihan($id)
    {
        $tagihan = TagihanPelanggan::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.tagihan_pelanggan', [
            'tagihan' => $tagihan,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-tagihan_pelanggan.pdf');
    }

    public function cetakPembayaranPiutang(Request $request, $id)
    {
        $mulaiId = $request->mulai;
        $selesaiId = $request->selesai;

        $bayar = PembayaranPiutang::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.pembayaran_piutang', [
            'mulaiId' => $mulaiId,
            'selesaiId' => $selesaiId,
            'bayar' => $bayar,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-tagihan_pelanggan.pdf');
    }

    public function cetakMutasiSaldo($id)
    {
        $mutasi =  MutasiSaldoAkun::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.mutasi_saldo', [
            'mutasi' => $mutasi,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-mutasi-saldo.pdf');
    }

    public function cetakJurnalAkun($id)
    {
        $jurnal =  JurnalAkun::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.jurnal_akun', [
            'jurnal' => $jurnal,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-mutasi-saldo.pdf');
    }

    public function tambahKontrabon()
    {
        return view('pages.keuangan-akuntansi.keuangan.kontrabon.tambah-kontrabon', [
            'title' => 'keuangan & akuntansi',
            'id' => ''
        ]);
    }

    public function editKontrabon($id)
    {
        return view('pages.keuangan-akuntansi.keuangan.kontrabon.tambah-kontrabon', [
            'title' => 'keuangan & akuntansi',
            'id' => $id
        ]);
    }

    public function tagihanPelanggan()
    {
        return view('pages.keuangan-akuntansi.keuangan.tagihan.daftar-tagihan', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function tambahTagihanPelanggan()
    {
        return view('pages.keuangan-akuntansi.keuangan.tagihan.tambah-tagihan', [
            'title' => 'keuangan & akuntansi',
            'id' => ''
        ]);
    }

    public function editTagihanPelanggan($id)
    {
        return view('pages.keuangan-akuntansi.keuangan.tagihan.tambah-tagihan', [
            'title' => 'keuangan & akuntansi',
            'id' => $id
        ]);
    }

    public function pembayaranHutang()
    {
        return view('pages.keuangan-akuntansi.keuangan.pembayaran-hutang.pembayaran-hutang', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function tambahPembayaranHutang()
    {
        return view('pages.keuangan-akuntansi.keuangan.pembayaran-hutang.tambah-pembayaran', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function lihatPembayaranHutang($id)
    {
        return view('pages.keuangan-akuntansi.keuangan.pembayaran-hutang.tambah-pembayaran', [
            'title' => 'keuangan & akuntansi',
            'id' => $id
        ]);
    }

    public function pembayaranPiutang()
    {
        return view('pages.keuangan-akuntansi.keuangan.pembayaran-piutang.pembayaran-piutang', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function tambahPembayaranPiutang()
    {
        return view('pages.keuangan-akuntansi.keuangan.pembayaran-piutang.tambah-pembayaran-piutang', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function editPembayaranPiutang($id)
    {
        return view('pages.keuangan-akuntansi.keuangan.pembayaran-piutang.tambah-pembayaran-piutang', [
            'title' => 'keuangan & akuntansi',
            'id' => $id
        ]);
    }

    public function mutasiSaldo()
    {
        return view('pages.keuangan-akuntansi.keuangan.mutasi-saldo', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function jurnalAkun()
    {
        return view('pages.keuangan-akuntansi.keuangan.jurnal-akun.jurnal-akun', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function tambahJurnalAkun()
    {
        return view('pages.keuangan-akuntansi.keuangan.jurnal-akun.tambah-jurnal-akun', [
            'title' => 'keuangan & akuntansi'
        ]);
    }
}