<?php

namespace App\Livewire\Utilities\Password;

use App\Models\PasswordAkses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class PasswordManager extends Component
{
    public $email, $oldPassword, $newPassword, $readonly;

    public function render()
    {
        return view('livewire.utilities.password.password-manager');
    }

    public function mount()
    {
        $akses =  PasswordAkses::where('type', 'open-price')->first();
        $this->email = $akses->email;
        if ($akses->status == 1) {
            $this->readonly = 'readonly';
        }
    }

    public function renewPassword()
    {
        $akses = PasswordAkses::where('type', 'open-price')->first();

        // Verifikasi password lama
        if (Hash::check($this->oldPassword, $akses->password)) {
            session()->flash('error', 'Password lama tidak sesuai.');
            return;
        }

        // Update password baru
        $akses->password = Hash::make($this->newPassword);
        $akses->save();

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function updateEmail()
    {
        $akses =  PasswordAkses::where('type', 'open-price')->first();
        if ($akses->status == 0) {
            $akses->email = $this->email;
            $akses->status = 1;
            $akses->save();
            session()->flash('success', 'Email berhasil diperbarui.');
        } else {
            session()->flash('error', 'Email tidak bisa diperbarui, silahkan kontak admin.');
        }
    }

    public function forgotPassword()
    {
        // Mencari email berdasarkan tipe 'open-price'
        $akses = PasswordAkses::where('type', 'open-price')->first();

        if ($akses) {
            // Membuat link reset password (misal dengan token yang di-generate)
            $token = bin2hex(random_bytes(32)); // Atau gunakan metode lain untuk token
            DB::table('password_reset_tokens')->insert([
                'email' => $akses->email,
                'token' =>  $token
            ]);
            $resetLink = url('/reset-password-harga?token=' . $token);

            // Simpan token di database jika perlu untuk memvalidasi nanti
            // $akses->update(['reset_token' => $token]);

            // Mengirim email
            Mail::to($akses->email)->send(new \App\Mail\ForgotPasswordMail($akses->email, $resetLink));

            // Berikan notifikasi sukses
            session()->flash('success', 'Link untuk reset password telah dikirim ke email.');
        } else {
            // Jika email tidak ditemukan, berikan pesan error
            session()->flash('error', 'Email tidak ditemukan.');
        }
    }
}