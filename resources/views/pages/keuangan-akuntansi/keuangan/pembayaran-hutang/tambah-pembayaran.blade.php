@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Detail Pembayaran Hutang
        </h2>
    </div>

    <livewire:keuangan-akutansi.pembayaran-hutang.tambah-pembayaran-hutang : :id="$id ?? null" />
@endsection
