@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Data Jurnal Akun
        </h2>
    </div>

    <livewire:keuangan-akutansi.jurnal-akun.data-jurnal-akun />
@endsection
