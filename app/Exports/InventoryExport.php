<?php

namespace App\Exports;

use App\Models\InventoryTable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class InventoryExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        $inventory = InventoryTable::all(); // Replace this with your actual data query

        return $inventory->map(function ($item) {
            // Map the item to exclude 'created_at' and 'updated_at' columns
            return collect($item)->except(['created_at', 'updated_at']);
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Inputter',
            'Nama Barang',
            'Merk',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Tahun Pengadaan',
            'Sumber',
            'Status',
            'Foto',
            'No Inventaris',
            'Jumlah',
            'Keterangan',
            'Kategori',
            'QR Number',
            'Posisi',

            // Add more column headings here as needed
        ];
    }
}

