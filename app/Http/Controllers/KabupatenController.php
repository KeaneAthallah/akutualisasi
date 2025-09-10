<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Route;

class KabupatenController extends Controller
{
    public function index()
    {
        return redirect()->route("data-capaian-kbpp");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
        ]);

        Kabupaten::create([
            "name" => $request->name,
        ]);

        return redirect()
            ->route("kabupatens.index")
            ->with("success", "Kabupaten berhasil ditambahkan!");
    }

    public function update(Request $request, Kabupaten $kabupaten)
    {
        $request->validate([
            "name" => "required|string|max:255",
        ]);

        $kabupaten->update([
            "name" => $request->name,
        ]);

        return redirect()
            ->route("kabupatens.index")
            ->with("success", "Kabupaten berhasil diperbarui!");
    }

    public function destroy(Kabupaten $kabupaten)
    {
        $kabupaten->delete();
        return redirect()
            ->route("kabupatens.index")
            ->with("success", "Kabupaten berhasil dihapus!");
    }
}
