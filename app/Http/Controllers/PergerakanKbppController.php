<?php

namespace App\Http\Controllers;

use App\Models\PergerakanKbpp;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PergerakanKbppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pergerakanKbpps = PergerakanKbpp::latest()->paginate(10);

        return view('pages.pergerakan-kbpp', compact('pergerakanKbpps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'waktu_pelaksanaan' => 'required|date',
            'tempat' => 'required|string|max:255',
            'link' => 'nullable|url|max:255'
        ]);

        try {
            PergerakanKbpp::create([
                'nama_kegiatan' => $request->nama_kegiatan,
                'waktu_pelaksanaan' => Carbon::parse($request->waktu_pelaksanaan),
                'tempat' => $request->tempat,
                'link' => $request->link
            ]);

            return redirect()->route('pergerakan-kbpp.index')
                ->with('success', 'Data Pergerakan KBPP berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('pergerakan-kbpp.index')
                ->with('error', 'Gagal menambahkan data. Silakan coba lagi.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PergerakanKbpp $pergerakanKbpp)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'waktu_pelaksanaan' => 'required|date',
            'tempat' => 'required|string|max:255',
            'link' => 'nullable|url|max:255'
        ]);

        try {
            $pergerakanKbpp->update([
                'nama_kegiatan' => $request->nama_kegiatan,
                'waktu_pelaksanaan' => Carbon::parse($request->waktu_pelaksanaan),
                'tempat' => $request->tempat,
                'link' => $request->link
            ]);

            return redirect()->route('pergerakan-kbpp.index')
                ->with('success', 'Data Pergerakan KBPP berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('pergerakan-kbpp.index')
                ->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PergerakanKbpp $pergerakanKbpp)
    {
        try {
            $pergerakanKbpp->delete();

            return redirect()->route('pergerakan-kbpp.index')
                ->with('success', 'Data Pergerakan KBPP berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pergerakan-kbpp.index')
                ->with('error', 'Gagal menghapus data. Silakan coba lagi.');
        }
    }
}
