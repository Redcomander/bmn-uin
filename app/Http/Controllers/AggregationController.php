<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AggregatedData;
use App\Models\InventoryTable as ModelsInventoryTable;

class AggregationController extends Controller
{
    public function aggregateAndStore()
    {

        // Truncate the AggregatedData table to remove all records
        AggregatedData::truncate();

        // Retrieve data from the InventoryTable
        $inventoryData = ModelsInventoryTable::all();

        // Perform data aggregation as needed
        $aggregatedData = [];
        foreach ($inventoryData as $data) {
            $kategori = $data->kategori;
            $jumlah = intval($data->jumlah);

            // Check if $kategori exists in $aggregatedData
            if (!isset($aggregatedData[$kategori])) {
                $aggregatedData[$kategori] = [];
            }

            // Add the value to the array for this kategori
            $aggregatedData[$kategori][] = $jumlah;
        }

        // Sum the values for each kategori
        foreach ($aggregatedData as $kategori => $values) {
            $sum = array_sum($values);
            AggregatedData::updateOrCreate(
                ['kategori' => $kategori],
                ['jumlah' => $sum]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Data Aggregation Complete');
    }

    // Additional methods for managing aggregated data as needed
}
