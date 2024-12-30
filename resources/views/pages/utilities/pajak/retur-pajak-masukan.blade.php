@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Retur Pajak Pembelian
        </h2>
    </div>

    <livewire:utilities.pajak.retur-pajak-masukan />
@endsection
