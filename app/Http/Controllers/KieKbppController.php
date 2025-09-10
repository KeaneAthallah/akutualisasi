<?php

namespace App\Http\Controllers;

use App\Models\KieKbpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KieKbppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kieKbpps = KieKbpp::latest()->paginate(10);
        return view('pages.kie-kbpp', compact('kieKbpps'));
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
            'ringkasan_materi' => 'required|string',
            'file' => 'nullable', // 10MB max
        ]);

        $data = [
            'title' => $request->title,
            'ringkasan_materi' => $request->ringkasan_materi,
            'file_name' => $request->file,
        ];

        // Handle file upload

        KieKbpp::create($data);

        return redirect()->route('kie-kbpp.index')->with('success', 'Data KIE KBPP berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KieKbpp $kieKbpp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KieKbpp $kieKbpp)
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
            'ringkasan_materi' => 'required|string',
            'file' => 'nullable', // 10MB max
        ]);

        $data = [
            'title' => $request->title,
            'ringkasan_materi' => $request->ringkasan_materi,
            'file_name' => $request->file,
        ];


        KieKbpp::findOrFail($id)->update($data);

        return redirect()->route('kie-kbpp.index')->with('success', 'Data KIE KBPP berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KieKbpp $kieKbpp)
    {
        $kieKbpp->delete();

        return redirect()->route('kie-kbpp.index')->with('success', 'Data KIE KBPP berhasil dihapus!');
    }
}
