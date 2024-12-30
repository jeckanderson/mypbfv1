@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">
            Lap. Rekap Piutang (Piutang Awal & Penjualan)
        </h2>
    </div>

    <livewire:utilities.piutang.rekap-piutang />
@endsection
