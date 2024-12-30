@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-primary text-lg font-medium">
            SP Pembelian
        </h2>
    </div>

    <livewire:utilities.pembelian.sp-pembelians />
@endsection
