@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Detail Surat Jalan
        </h2>
    </div>

    <livewire:penjualan.surat-jalan.tambah-surat-jalan :isChangeStatus="$isChangeStatus" :id="$id" />
@endsection
