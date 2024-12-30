<?php

namespace App\Livewire\Master;

use App\Models\Ekspedisi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class DataEkspedisi extends Component
{
    #[On('refreshTableEkspedisi')]
    public function render()
    {
        return view('livewire.master.data-ekspedisi', [
            'dataEkspedisi' => Ekspedisi::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }

    public function deleteEKspedisi($id)
    {
        $delete = Ekspedisi::find($id)->delete();
        if ($delete) {
            return redirect('/ekspedisi');
        }
    }
}
