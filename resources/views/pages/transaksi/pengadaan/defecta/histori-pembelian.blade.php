@extends('layout.main')

@section('main')
    @php
        use App\Models\ObatBarang;
    @endphp
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-pending font-medium">
            HPP {{ ObatBarang::find($id)->nama_obat_barang }}
        </h2>
    </div>

    <livewire:pengadaan.lihat-hpp.histori-pembelian :id="$id" />
@endsection
