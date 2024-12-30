<?php

namespace App\Livewire\Persediaan;

use Livewire\Component;

class KartuStok extends Component
{
    public $historys;
    public $searchTerm = '';

    public function render()
    {
        $filteredHistorys = $this->historys;

        if ($this->searchTerm) {
            $filteredHistorys = $filteredHistorys->filter(function ($history) {
                return stripos($history->no_batch, $this->searchTerm) !== false ||
                    stripos($history->no_faktur, $this->searchTerm) !== false;
            });
        }

        return view('livewire.persediaan.kartu-stok', ['dataHistory' => $filteredHistorys]);
    }
}
