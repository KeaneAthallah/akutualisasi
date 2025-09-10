<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\MonthlyProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        // Filter kabupaten
        $kabupatenId = $request->get("kabupaten_id_kec");

        // Ambil semua kabupaten untuk dropdown
        $allKabupatens = Kabupaten::query()->orderBy("name")->get();

        // Ambil bulan terakhir dari monthly_progress
        $latestMonth = MonthlyProgress::query()
            ->select("month")
            ->orderBy("month", "desc")
            ->value("month");

        // Query kecamatan + capaian (join monthly_progress)
        $kecamatans = Kecamatan::with("kabupaten")
            ->when($kabupatenId, function ($query) use ($kabupatenId) {
                $query->where("kabupaten_id", $kabupatenId);
            })
            ->withSum(
                [
                    "monthlyProgress as capaian_kbpp" => function ($q) use (
                        $latestMonth,
                    ) {
                        $q->where("month", "<=", $latestMonth);
                    },
                ],
                "capaian_kbpp",
            )
            ->withSum(
                [
                    "monthlyProgress as capaian_mkjp" => function ($q) use (
                        $latestMonth,
                    ) {
                        $q->where("month", "<=", $latestMonth);
                    },
                ],
                "capaian_mkjp",
            )
            ->orderBy("year", "desc")
            ->paginate(10);

        return view("kecamatans.index", [
            "kecamatans" => $kecamatans,
            "allKabupatens" => $allKabupatens,
            "kabupatenFilterForKecamatan" => $kabupatenId,
            "latest_month" => $latestMonth,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "kabupaten_id" => "required|exists:kabupatens,id",
            "name" => "required|string|max:255",
            "year" => "required|integer",
            "target_kbpp" => "nullable|integer",
            "target_mkjp" => "nullable|integer",
        ]);

        Kecamatan::create($request->all());

        return redirect()
            ->route("data-capaian-kbpp")
            ->with("success", "Data kecamatan berhasil ditambahkan.");
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            "kabupaten_id" => "required|exists:kabupatens,id",
            "name" => "required|string|max:255",
            "year" => "required|integer",
            "target_kbpp" => "nullable|integer",
            "target_mkjp" => "nullable|integer",
        ]);

        $kecamatan->update($request->all());

        return redirect()
            ->route("data-capaian-kbpp")
            ->with("success", "Data kecamatan berhasil diperbarui.");
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()
            ->route("data-capaian-kbpp")
            ->with("success", "Data kecamatan berhasil dihapus.");
    }

    // Export to Excel (optional, requires Laravel Excel)
    public function export(Request $request)
    {
        $kabupatenId = $request->get("kabupaten_id_kec");
        // Example: Export using Laravel Excel
        // return Excel::download(new KecamatanExport($kabupatenId), 'kecamatans.xlsx');
    }
}
