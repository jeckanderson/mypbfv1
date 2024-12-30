<?php

namespace App\Exports\Pbf;

use Maatwebsite\Excel\Concerns\FromView;

class DistribusiExport implements FromView
{
    protected $query;
    protected $mulaiId;


    public function __construct($query, $mulaiId)
    {
        $this->query = $query;
        $this->mulaiId = $mulaiId;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        // Fetch the data using the query
        $detail = $this->query->get();

        // Return the view with the data and the additional variables
        return view('excel.pbf.was-distribusi.excel', [
            'detail' => $detail,
            'mulaiId' => $this->mulaiId,

        ]);
    }
}
