<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SetHargaExport implements FromView
{
    protected $setharga;

    public function __construct($setharga)
    {
        $this->setharga = $setharga;
    }

    public function view(): View
    {
        return view('pdf.utilities.produk.price-list-produk.excel', [
            'setharga' => $this->setharga
        ]);
    }
}
