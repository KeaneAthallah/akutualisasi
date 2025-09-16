<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyProgressImport;
use App\Models\MonthlyProgress;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MonthlyProgressController extends Controller
{
    public function index(Request $request)
    {
        $query = MonthlyProgress::with(["kecamatan.kabupaten"]);

        if ($request->filled("kabupaten_id")) {
            $query->whereHas("kecamatan.kabupaten", function ($q) use (
                $request,
            ) {
                $q->where("id", $request->kabupaten_id);
            });
        }

        if ($request->filled("kecamatan_id")) {
            $query->where("kecamatan_id", $request->kecamatan_id);
        }

        $progress = $query->latest()->paginate(10);

        return view("monthly_progress.index", [
            "progress" => $progress,
            "allKabupatens" => Kabupaten::all(),
            "allKecamatans" => Kecamatan::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "kecamatan_id" => "required|exists:kecamatans,id",
            "month" => "required|string|max:20",
            "capaian_kbpp" => "required|integer|min:0",
            "capaian_mkjp" => "required|integer|min:0",
        ]);

        MonthlyProgress::create($validated);

        return redirect()
            ->back()
            ->with("success", "Data berhasil ditambahkan.");
    }

    public function update(Request $request, MonthlyProgress $monthlyProgress)
    {
        $validated = $request->validate([
            "kecamatan_id" => "required|exists:kecamatans,id",
            "month" => "required|string|max:20",
            "capaian_kbpp" => "required|integer|min:0",
            "capaian_mkjp" => "required|integer|min:0",
        ]);

        $monthlyProgress->update($validated);

        return redirect()->back()->with("success", "Data berhasil diperbarui.");
    }

    public function destroy(MonthlyProgress $monthlyProgress)
    {
        $monthlyProgress->delete();

        return redirect()->back()->with("success", "Data berhasil dihapus.");
    }
    public function import(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        Excel::import(new MonthlyProgressImport($request->kecamatan_id), $request->file('file'));

        return redirect()->back()->with('success', 'Data Monthly Progress berhasil diimpor!');
    }
}
