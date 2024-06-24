<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Create a query builder instance
        $query = BeritaAcara::query();

        // Add the search conditions to the query
        $query->where('berita_acara', 'LIKE', '%' . $search . '%')
            ->orWhere('tanggal', 'LIKE', '%' . $search . '%');

        // Execute the query and paginate the results
        $acara = $query->paginate(10);

        return view('berita_acara.index', compact('acara'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('berita_acara.create');
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
            'file' => 'required|mimes:doc,docx,pdf',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName); // Move the uploaded file to a public directory

            BeritaAcara::create([
                "berita_acara" => $request->berita_acara,
                "tanggal" => $request->tanggal,
                "file" => $fileName, // Store the file's name in the "file" field
            ]);

            return redirect('berita_acara');
        }
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
        $acara = BeritaAcara::find($id);
        return view('berita_acara.edit', compact('acara'));
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
        $request->validate([
            'file' => 'nullable|mimes:doc,docx,pdf|max:2048',
        ]);

        // Retrieve the current record
        $beritaAcara = BeritaAcara::find($id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);

            // If a new file is uploaded, update the "file" field
            $beritaAcara->file = $fileName;
        }

        // Update other fields
        $beritaAcara->berita_acara = $request->berita_acara;
        $beritaAcara->tanggal = $request->tanggal;

        $beritaAcara->save(); // Save the changes to the database

        return redirect('berita_acara');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BeritaAcara::destroy($id);
        return redirect('/berita_acara');
    }
}
