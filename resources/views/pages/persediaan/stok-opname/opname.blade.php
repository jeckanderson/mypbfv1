@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Stok Opname
        </h2>
    </div>
    <livewire:persediaan.stock-opname.opname />
@endsection
