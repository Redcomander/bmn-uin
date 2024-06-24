<?php

namespace App\Imports;

use App\Models\Inventory;
use App\Models\InventoryTable;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventoryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Set "tanggal_masuk" to the user input or use a default date if it's not provided
        $tanggalInput = $row['tanggal_input'] ?? now(); // Default to the current date if not provided

        // If 'status' is null, set it to "Barang Masuk"
        $status = $row['status'] ?? 'Barang Masuk';

        // Generate the barcode
        $barcode = $this->generateBarcode($tanggalInput);

        // Check if the same data already exists in the database
        $existingRecord = InventoryTable::where('nama_barang', $row['nama_barang'] ?? null)
            ->where('merk', $row['merk'] ?? null)
            ->where('no_inventaris', $row['no_inventaris'] ?? null)
            ->where('posisi', $row['posisi'] ?? null)
            ->first();

        if (!$existingRecord) {
            // Map Excel columns to Inventory model fields, allowing nullable data
            $inventoryData = [
                'inputter_name' => auth()->user()->name,
                'nama_barang' => $row['nama_barang'] ?? 'No Data',
                'merk' => $row['merk'] ?? 'No Data',
                'tanggal_input' => $tanggalInput,
                'tanggal_keluar' => $row['tanggal_keluar'] ?? 'No Data',
                'tahun_pengadaan' => $row['tahun_pengadaan'] ?? 'No Data',
                'status' => $status,
                'foto' => $row['foto'] ?? 'No Data',
                'no_inventaris' => $row['no_inventaris'] ?? 'No Data',
                'jumlah' => $row['jumlah'] ?? 'No Data',
                'keterangan' => $row['keterangan'] ?? 'No Data',
                'sumber' => $row['sumber'] ?? 'No Data',
                'barcode' => $barcode,
                'posisi' => $row['posisi'] ?? 'No Data',
                'kategori' => strtoupper($row['kategori'] ?? 'No Data'),
            ];

            return new InventoryTable($inventoryData);
        }

        // If the same data already exists, skip importing that row
        return null;
    }

    // Generate the barcode based on tanggal_masuk
    private function generateBarcode($tanggalInput)
    {
        // You can customize the barcode generation logic here.
        // For simplicity, we'll use the ID and a formatted date as an example.
        $id = InventoryTable::max('id') + 1; // Get the next available ID
        $formattedDate = $tanggalInput->format('Ymd'); // Format the date as YYYYMMDD

        // Combine the ID and formatted date to create the barcode
        $barcode = $id . $formattedDate;

        return (string) $barcode; // Convert to an integer
    }
}
