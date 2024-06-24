<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use App\Models\InventoryTable;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\DB;



class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('log')->only(['store', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchField = $request->input('search_field');

        $inventory = InventoryTable::query();

        if (!empty($search)) {
            $inventory->where($searchField, 'LIKE', '%' . $search . '%');
        }

        $inventory = $inventory->paginate(10);

        return view('list_barang.index', compact('inventory'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('list_barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif|nullable',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('gambar_barang', 'public');
        } else {
            $foto = null;
        }

        $tanggalInput = Carbon::now();
        $inputterName = Auth::user()->name;
        $uniqueString = $this->generateUniqueString($request);

        $inventory = InventoryTable::create([
            "inputter_name" => $inputterName,
            "nama_barang" => $request->nama_barang,
            "tanggal_input" => $tanggalInput,
            "tanggal_keluar" => $request->tanggal_keluar,
            "tahun_pengadaan" => $request->tahun_pengadaan,
            "status" => "Barang Masuk",
            "barcode" => $uniqueString,
            "merk" => $request->merk,
            "foto" => $foto,
            "posisi" => $request->posisi,
            "no_inventaris" => $request->no_inventaris,
            "jumlah" => $request->jumlah,
            "keterangan" => $request->keterangan,
            "kategori" => strtoupper($request->kategori),
        ]);

        return redirect('inventory')->with('success', 'Record created successfully.');
    }

    private function generateUniqueString(Request $request)
    {
        $id = DB::table('inventory')->max('id'); // Get the maximum id from the inventories table
        $tanggalInput = date('Ymd', strtotime(Carbon::now())); // Format the current date as Ymd

        // Concatenate the id and formatted tanggalMasuk
        $uniqueString = (int)($id . $tanggalInput);

        return $uniqueString;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryTable $inventory)
    {
        return view('list_barang.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentInventory = InventoryTable::find($id);
        $currentBarcode = $currentInventory->barcode;
        $currentTanggalInput = $currentInventory->tanggal_input;
        $currentStatus = $currentInventory->status;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('gambar_barang', 'public');
        } else {
            $foto = $request->input('current_foto');
        }

        $inputterName = Auth::user()->name;

        // Check if the status is being updated to "Barang Keluar"
        if ($request->status == "Barang Keluar" && $currentStatus != "Barang Keluar") {
            $tanggalKeluar = now(); // Set the current date and time
        } else {
            $tanggalKeluar = $request->tanggal_keluar ?: null;
        }

        $updatedAttributes = [
            "inputter_name" => $inputterName,
            "nama_barang" => $request->nama_barang,
            "tanggal_input" => $currentTanggalInput,
            "tanggal_keluar" => $tanggalKeluar,
            "tahun_pengadaan" => $request->tahun_pengadaan,
            "status" => $request->status ?: $currentStatus,
            "barcode" => $currentBarcode,
            "merk" => $request->merk,
            "foto" => $foto,
            "posisi" => $request->posisi,
            "no_inventaris" => $request->no_inventaris,
            "jumlah" => $request->jumlah,
            "kategori" => strtoupper($request->kategori),
        ];

        InventoryTable::where('id', $id)->update($updatedAttributes);

        return redirect('inventory')->with('success', 'Record updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the item by ID
        $inventory = InventoryTable::find($id);

        if (!$inventory) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        InventoryTable::destroy($id);
        return redirect('/inventory');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $path = $request->file('file')->getRealPath();
        Excel::import(new InventoryImport, $path, null, \Maatwebsite\Excel\Excel::XLSX);

        return redirect('inventory')->with('success', 'Data imported successfully.');
    }

    public function export()
    {
        return Excel::download(new InventoryExport, 'inventory.xlsx');
    }
    public function getKategoriData()
    {
        $kategoriData = InventoryTable::select('kategori')
            ->groupBy('kategori')
            ->selectRaw('count(*) as count')
            ->get();

        return response()->json($kategoriData);
    }
}
