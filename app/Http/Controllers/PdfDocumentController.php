<?php

namespace App\Http\Controllers;

use App\Models\PdfDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = PdfDocument::latest()->paginate(10);
        return view('pages.advokasi-kbpp', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'signer' => 'required|string|max:255',
            'file' => 'nullable', // 10MB max
        ]);

        $data = [
            'title' => $request->title,
            'no_surat' => $request->signer,
            'file_path' => $request->file,
        ];

        PdfDocument::create($data);

        return redirect()->back()->with('success', 'Document berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PdfDocument $pdfDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PdfDocument $pdfDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'signer' => 'required|string|max:255',
            'file' => 'nullable', // 10MB max
        ]);

        $data = [
            'title' => $request->title,
            'no_surat' => $request->signer,
            'file_path' => $request->input('file'),
        ];


        PdfDocument::findOrFail($id)->update($data);

        return redirect()->back()->with('success', 'Document berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $document = PdfDocument::findOrFail($id);

            // Delete the record
            $document->delete();

            return redirect()->back()->with('success', 'Document berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus document: ' . $e->getMessage());
        }
    }
}
