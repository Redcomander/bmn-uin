<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\AggregatedData;
use App\Models\InventoryTable;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $data2 = AggregatedData::all();
        $data = InventoryTable::all();

        // Group the data by "tahun" and calculate counts
        $tahun = $data->groupBy('tahun_pengadaan')->map(function ($group) {
            $barangMasukCount = $group->where('status', 'Barang Masuk')->count();
            $barangKeluarCount = $group->where('status', 'Barang Keluar')->count();

            return [
                'Barang Masuk' => $barangMasukCount,
                'Barang Keluar' => $barangKeluarCount,
            ];
        });
        $data2 = $data2->pluck('jumlah', 'kategori');
        $kategori = AggregatedData::all();

        return view('dashboard', compact('recentActivities', 'data', 'tahun', 'data2', 'kategori'));
    }
}
