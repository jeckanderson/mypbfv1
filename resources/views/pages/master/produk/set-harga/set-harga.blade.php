@php
    use Livewire\Features\SupportFormObjects\Form;
    use App\Models\SetHarga;
@endphp
@extends('layout.main')

@section('main')
    @include('components.alert')
    <div class="flex items-center mt-8 intro-y">
        <a href="/obat-dan-barang"><button class="mr-2 btn btn-outline-pending"><i data-feather="corner-up-left"
                    class="w-4 h-4 mr-1"></i>
                Kembali</button></a>
        <h2 class="mr-auto text-lg font-medium text-pending">
            Setting Harga Jual {{ $produk->nama_obat_barang }}

        </h2>
    </div>

    <livewire:produk.set-harga.set-harga :id="$id" />

    </form>
    @include('pages.master.produk.set-harga.javascript')
@endsection
