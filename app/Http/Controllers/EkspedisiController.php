<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkspedisiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_ekspedisi']);
    }
    public function index()
    {
        return view('pages.master.ekspedisi', [
            'title' => 'master'
        ]);
    }
}