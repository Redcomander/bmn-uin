<?php

namespace App\Http\Controllers;

use App\Models\InventoryTable;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class DaftarRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $filter = $request->input('filter'); // Get the selected filter from the request

        $inventory = InventoryTable::when($filter, function ($query) use ($filter) {
            return $query->where('posisi', $filter);
        })->orderBy('posisi')->paginate(50);

        $filters = InventoryTable::selectRaw('TRIM(BOTH " " FROM posisi) as posisi')
            ->distinct('posisi')
            ->orderBy('posisi')
            ->get();

        return view('daftar-ruangan.ruangan', compact('inventory', 'filters', 'filter'));
    }

    public function downloadPDF(Request $request)
    {
        $filter = $request->input('filter'); // Get the selected filter from the request

        $inventory = InventoryTable::when($filter, function ($query) use ($filter) {
            return $query->where('posisi', $filter);
        })->orderBy('posisi')->get();

        $pdf = PDF::loadView('pdf.ruangan', compact('inventory', 'filter'));

        return $pdf->download('inventory_report.pdf');
    }

    public function downloadWord(Request $request)
    {
        $filter = $request->input('filter'); // Get the selected filter from the request

        $inventory = InventoryTable::when($filter, function ($query) use ($filter) {
            return $query->where('posisi', $filter);
        })->orderBy('posisi')->get();

        // Load your Word template
        $templatePath = public_path('templates/template_download.docx');
        $template = new TemplateProcessor($templatePath);

        // Clone the table row based on the number of records in the inventory
        $template->cloneRow('No', count($inventory));

        // Loop through your data and populate the table
        $rowIndex = 1; // Start with the first row in the template
        foreach ($inventory as $col) {
            $template->setValue('Posisi', $col->posisi);
            $template->setValue("No#$rowIndex", $rowIndex); // Set the 'No' value
            $template->setValue("Nama_Barang#$rowIndex", $col->nama_barang);
            $template->setValue("Merk#$rowIndex", $col->merk);
            $template->setValue("Tahun#$rowIndex", $col->tahun);
            $template->setValue("No_inv#$rowIndex", $col->no_inventaris);
            $template->setValue("Jumlah#$rowIndex", $col->jumlah);
            $template->setValue("Ket#$rowIndex", $col->keterangan);

            $rowIndex++;
        }

        // Generate a temporary Word file
        $tempWordFilePath = storage_path('app/temp_document.docx');
        $template->saveAs($tempWordFilePath);

        // Prepare the Word document for download
        return response()->download($tempWordFilePath, 'inventory_report.docx')->deleteFileAfterSend(true);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
