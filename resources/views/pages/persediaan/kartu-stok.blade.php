@extends('layout.main')
<?php
use App\Models\HistoryStok;
?>

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <a href="/histori-stok"><button class="mr-2 btn btn-pending"><i data-feather="corner-up-left" class="w-4 h-4 mr-1"></i>
                Kembali</button></a>
        <h2 class="mr-auto text-lg font-medium text-primary">
            Kartu Stok
        </h2>
    </div>
    <livewire:persediaan.kartu-stok :historys="$historys" />
@endsection
