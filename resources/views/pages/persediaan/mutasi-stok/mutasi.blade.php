@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Mutasi Stok
        </h2>
    </div>
    <livewire:persediaan.mutasi-stok.mutasi />
@endsection
