@php
    use Picqer\Barcode\BarcodeGeneratorHTML;
    use Illuminate\Support\Collection;

    $generator = new BarcodeGeneratorHTML();
    // Mengurutkan koleksi $produks berdasarkan nama produk dalam urutan alfabetis
    $produks = $produks->sortBy('nama_obat_barang');
@endphp

@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Barcode Produk
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-1 mt-8">
        @include('components.search', [
            'id_table' => 'myTable',
        ])
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-2 overflow-auto intro-y lg:overflow-visible">
        <table class="table -mt-2 table-report" id="myTable">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Kode Barcode</th>
                    <th class="whitespace-nowrap">NIE</th>
                    <th class="whitespace-nowrap">Kode E-report</th>
                    <th class="whitespace-nowrap">Nama Produk</th>
                    <th class="whitespace-nowrap">Barcode Batang</th>
                    {{-- <th class="whitespace-nowrap">QR Code</th> --}}
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $produk)
                    <tr class="intro-x">
                        <td class="w-20">{{ $loop->iteration }}</td>
                        <td class="">{{ $produk->barcode_produk }}</td>
                        <td class="">{{ $produk->no_ijin_edar }}</td>
                        <td class="">{{ $produk->kode_obat_barang }}</td>
                        <td class="">{{ $produk->nama_obat_barang }}</td>
                        <td class="">
                            {!! $generator->getBarcode($produk->barcode_produk, $generator::TYPE_CODE_128) !!} {{ $produk->barcode_produk }}</td>
                        {{-- <td class="">
                            {!! QrCode::size(100)->generate($produk->barcode_produk) !!}
                        </td> --}}
                        <td class="w-56 table-report__action">
                            {{-- <a class="flex items-center text-primary"
                                href="{{ route('download.barcode', ['data' => $produk->barcode_produk]) }}">
                                <i data-feather="cloud" class="w-4 h-4 mr-1"></i> Barcode Batang
                            </a> --}}
                            <a class="flex items-center"
                                href="{{ route('download.barcode', ['data' => $produk->barcode_produk]) }}">
                                <i data-feather="printer" class="w-4 h-4 mr-1"></i> Barcode Batang
                            </a>
                            {{-- <a class="flex items-center text-primary"
                                href="{{ route('download.barcode', ['data' => $produk->barcode_produk]) }}">
                                <i data-feather="cloud" class="w-4 h-4 mr-1"></i> QR Code
                            </a> --}}

                            {{-- //*barcode QR new// --}}
                            {{-- <a class="flex items-center text-pending"
                                href="{{ route('download.barcode', ['data' => $produk->barcode_produk]) }}">
                                <i data-feather="printer" class="w-4 h-4 mr-1"></i> QR Code
                            </a> --}}
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td colspan="7" class="font-bold text-pending text-center">Data belum tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
@endsection
