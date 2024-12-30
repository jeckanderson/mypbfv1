<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordManagerController extends Controller
{
    public function index()
    {
        return view('pages.utilities.password-manager', [
            'title' => 'utilities'
        ]);
    }

    public function resetPassword(Request $request)
    {
        // Ambil token dari URL
        $token = $request->query('token');

        // Cari pengguna dengan token reset yang valid
        $akses = DB::table('password_reset_tokens')->where('token', $token)->first();

        if ($akses) {
            // Tampilkan form untuk reset password
            return view('pages.utilities.reset-password', ['token' => $token, 'title' => 'utilities']);
        } else {
            // Token tidak valid atau sudah kadaluarsa
            return redirect('/password-manager')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
        }
    }
}
