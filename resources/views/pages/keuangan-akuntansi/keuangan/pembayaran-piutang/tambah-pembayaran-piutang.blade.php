@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Detail Pembayaran Piutang
        </h2>
    </div>

    <livewire:keuangan-akutansi.piutang.tambah-pembayaran-piutang :id="$id ?? null" />
@endsection
