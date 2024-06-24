<?php

namespace App\Http\Livewire;

use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\InventoryTable;


class Inventory extends Component
{

    public $request, $path, $page, $export, $fileName, $pdf, $col, $ids;
    public $qrCodeUrls = [];
    public $perPage = 10;
    public $currentPage = 1;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
            $inventory = InventoryTable::orderBy('id', 'asc')->paginate(10);
        return view('livewire.inventory', ['inventory' => $inventory]);
    }

    private $inventory;

    public function mount($inventory)
    {

        $this->inventory = $inventory;
        // Generate QR code URLs for each item in $inventory
        foreach ($this->inventory as $col) {
            $this->qrCodeUrls[$col->id] = QrCode::size(400)->generate($col->barcode);
        }
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $path = $request->file('file')->getRealPath();
        Excel::import(new InventoryImport, $path);

        return redirect('inventory')->with('success', 'Data imported successfully.');
    }

    public function exportExcelForPage($page)
    {

        $inventory = InventoryTable::paginate(10, ['*'], 'page', $page);
        $export = new InventoryExport($inventory);
        $fileName = 'Data_BMN_Page_' . $page . '.xlsx';
        return Excel::download($export, $fileName);
    }

    public function exportExcel()
    {
        $page = 1; // Export the first page
        return $this->exportExcelForPage($page);
    }

    public function exportPdfForpage($page)
    {
        $inventory = InventoryTable::paginate(10, ['*'], 'page', $page); // Your data here
        $pdf = PDF::loadView('pdf.inventory', compact('inventory'));
        // dd($inventory);
        return $pdf->download('Data BMN.pdf');
    }

    public function exportPdf()
    {
        $page = 1; // Export the first page
        return $this->exportPdfForPage($page);
    }

    public function generateQRCodeData($col)
    {
        // Emit the event with data
        $this->emit('qrCodeData', $col->barcode, $col->nama_barang, $col->posisi, $col->merk);
    }
}
