<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:akses_dashboard_admin')->only('admin');
        // $this->middleware('permission:akses dashboard sales')->only('sales');
        // $this->middleware('permission:akses dashboard apoteker')->only('apoteker');
        // $this->middleware('permission:akses dashboard keuangan')->only('keuangan');
        // $this->middleware('permission:akses dashboard gudang')->only('gudang');
    }

    public function admin()
    {
        return view('pages.dashboard.admin', [
            'title' => 'dashboard',
        ]);
    }

    public function sales()
    {
        return view('pages.dashboard.marketing', [
            'title' => 'dashboard'
        ]);
    }

    public function apoteker()
    {
        return view('pages.dashboard.apoteker', [
            'title' => 'dashboard'
        ]);
    }

    public function keuangan()
    {
        return view('pages.dashboard.keuangan', [
            'title' => 'dashboard'
        ]);
    }

    public function gudang()
    {
        return view('pages.dashboard.gudang', [
            'title' => 'dashboard'
        ]);
    }
}