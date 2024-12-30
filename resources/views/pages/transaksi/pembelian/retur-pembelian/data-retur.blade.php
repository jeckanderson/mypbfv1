@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Data Retur Pembelian
        </h2>
    </div>

    <livewire:pembelian.retur-pembelian.data-retur-pembelian />
@endsection
