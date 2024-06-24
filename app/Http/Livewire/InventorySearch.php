<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inventory;

class InventorySearch extends Component
{
    public $search = '';

    public function render()
    {
        $inventory = Inventory::where('nama_barang', 'like', '%' . $this->search . '%')
            ->orWhere('merk', 'like', '%' . $this->search . '%')
            ->orWhere('no_inventaris', 'like', '%' . $this->search . '%')
            ->get();

        return view('list_barang.index', ['inventory' => $inventory]);
    }
}
