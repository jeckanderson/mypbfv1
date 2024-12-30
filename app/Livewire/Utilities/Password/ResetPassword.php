<?php

namespace App\Livewire\Utilities\Password;

use App\Models\PasswordAkses;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ResetPassword extends Component
{
    public $password, $passwordConfirmation, $token;
    public function render()
    {
        return view('livewire.utilities.password.reset-password');
    }

    public function renewPassword()
    {
        $akun = PasswordAkses::where('type', 'open-price')->first();

        if ($this->password == $this->passwordConfirmation) {
            $akun->password = $this->password;
            $akun->save();
            DB::table('password_reset_tokens')->where('token', $this->token)->delete();
            return redirect('password-manager')->with('success', 'Password berhasil diperbarui.');
        } else {
            session()->flash('error', 'Password tidak sama.');
        }
    }
}