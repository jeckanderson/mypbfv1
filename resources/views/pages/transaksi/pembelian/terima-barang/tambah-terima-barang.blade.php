@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Detail Terima Barang
        </h2>
    </div>
    <livewire:terima-barang.tambah.tambah-terima-barang :id="$id" />
@endsection
