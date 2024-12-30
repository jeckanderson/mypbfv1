@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Surat Pesanan Penjualan
        </h2>
    </div>
    <livewire:penjualan.sp-penjualan.detail-sp-penjualan />
@endsection
