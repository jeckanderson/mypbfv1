@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Analisis Pareto ABC
        </h2>
    </div>

    {{-- modal start --}}
    <div id="modal-informasi" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="p-10 modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-white border border-slate-600 bg-danger">Kelas</td>
                                <td class="text-white border border-slate-600 bg-danger">Jumlah Item</td>
                                <td class="text-white border border-slate-600 bg-danger">Nilai Penjualan
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-slate-600">A</td>
                                <td class="border border-slate-600">10% - 20%</td>
                                <td class="border border-slate-600">70% - 80%</td>
                            </tr>
                            <tr>
                                <td class="border border-slate-600">B</td>
                                <td class="border border-slate-600">10% - 20%</td>
                                <td class="border border-slate-600">15% - 20%</td>
                            </tr>
                            <tr>
                                <td class="border border-slate-600">C</td>
                                <td class="border border-slate-600">60% - 80%</td>
                                <td class="border border-slate-600">5% - 15%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- modal end --}}

    <livewire:pengadaan.analisis-pareto />
@endsection
