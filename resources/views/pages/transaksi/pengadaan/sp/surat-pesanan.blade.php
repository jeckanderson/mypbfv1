@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Data Pesanan ke Supplier
        </h2>
    </div>

    @livewire('pembuatan-sp.surat-pesanan')
@endsection
