@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Pajak Penjualan
        </h2>
    </div>

    <livewire:utilities.pajak.pajak-keluaran />
@endsection
