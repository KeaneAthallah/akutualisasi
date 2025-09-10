<?php

use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KieKbppController;
use App\Http\Controllers\MonthlyProgressController;
use App\Http\Controllers\PergerakanKbppController;
use App\Http\Controllers\ProfileController;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\MonthlyProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KecamatansExport;
use App\Exports\KabupatensExport;
use App\Exports\MonthlyProgressExport;
use App\Http\Controllers\PdfDocumentController;
use App\Models\KieKbpp;
use App\Models\PdfDocument;
use App\Models\PergerakanKbpp;

Route::get('/pergerakan', function (Request $request) {
    $search = $request->get('search');

    $query = PergerakanKbpp::query();

    if ($search) {
        $query->where('nama_kegiatan', 'like', "%{$search}%")
            ->orWhere('tempat', 'like', "%{$search}%")
            ->orWhere('waktu_pelaksanaan', 'like', "%{$search}%");
    }

    $items = $query->orderBy('waktu_pelaksanaan', 'desc')->paginate(9);

    return view('pages.partsials.pergerakan', compact('items', 'search'));
})->name('pergerakan');
Route::get('/kie', function (Request $request) {
    $query = KieKbpp::query()->latest();

    // Simple search filter
    $search = $request->get('search');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('ringkasan_materi', 'like', "%{$search}%");
        });
    }

    $items = $query->get();

    return view('pages.partsials.kie', [
        'items' => $items,
        'search' => $search,
    ]);
})->name('kie');
Route::get('/advokasi', function (Request $request) {
    $query = PdfDocument::query()->latest();

    // Simple search filter
    $search = $request->get('search');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('no_surat', 'like', "%{$search}%");
        });
    }

    $items = $query->get();

    return view('pages.partsials.advokasi', [
        'items' => $items,
        'search' => $search,
    ]);
})->name('advokasi');
Route::resource('documents', PdfDocumentController::class)->only(['index', 'store', 'update', 'destroy']);
Route::get("/", function () {
    $services = [
        [
            "id" => "family-planning",
            "title" => "Program Keluarga Berencana",
            "description" =>
            "Layanan konseling dan edukasi untuk perencanaan keluarga yang bertanggung jawab",
            "color" => "from-blue-500 to-blue-600",
            "icon_svg" =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>',
            "action_url" => "",
            "additional_info" =>
            "Konsultasi dengan bidan dan dokter spesialis kandungan untuk program KB yang tepat.",
        ],
        [
            "id" => "reproductive-health",
            "title" => "Kesehatan Reproduksi",
            "description" =>
            "Informasi dan layanan kesehatan reproduksi untuk keluarga Indonesia",
            "color" => "from-green-500 to-green-600",
            "icon_svg" =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>',
            "action_url" => "",
        ],
        [
            "id" => "population-development",
            "title" => "Pembangunan Keluarga",
            "description" =>
            "Program pemberdayaan dan pengembangan kualitas keluarga Indonesia",
            "color" => "from-teal-500 to-teal-600",
            "icon_svg" =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            "action_url" => "",
        ],
        [
            "id" => "education",
            "title" => "Edukasi & Penyuluhan",
            "description" =>
            "Materi edukatif dan program penyuluhan untuk masyarakat",
            "color" => "from-indigo-500 to-indigo-600",
            "icon_svg" =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
            "action_url" => "",
        ],
        [
            "id" => "consultation",
            "title" => "Konsultasi Online",
            "description" =>
            "Layanan konsultasi online dengan tenaga ahli berpengalaman",
            "color" => "from-purple-500 to-purple-600",
            "icon_svg" =>
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>',
            "action_url" => "",
        ],
    ];

    $contact = [
        "phone" => "(021) 8009091",
        "email" => "info@bkkbn.go.id",
        "website" => "https://www.bkkbn.go.id",
    ];
    return view("welcome", compact("services", "contact"));
});
Route::get("/api/dashboard-data", function (Request $request) {
    $kabupatenId = $request->input("kabupaten_id");
    $kecamatanId = $request->input("kecamatan_id");

    $allKabupatens = Kabupaten::orderBy("name")->get();

    // Load kecamatans for dropdown
    $kecamatansQuery = Kecamatan::query();
    if ($kabupatenId) {
        $kecamatansQuery->where("kabupaten_id", $kabupatenId);
    }
    $allKecamatans = $kecamatansQuery->orderBy("name")->get();

    // Get kecamatan targets based on filters
    $kecamatanQuery = Kecamatan::query();
    if ($kabupatenId) {
        $kecamatanQuery->where("kabupaten_id", $kabupatenId);
    }
    if ($kecamatanId) {
        $kecamatanQuery->where("id", $kecamatanId);
    }
    $kecamatans = $kecamatanQuery->get();

    // Calculate totals from kecamatan targets (not sum from progress)
    $totalTarget = $kecamatans->sum("target_kbpp");
    $totalTargetMkjp = $kecamatans->sum("target_mkjp");

    // Get latest progress for each kecamatan using the correct table name
    $latestProgressQuery = MonthlyProgress::with("kecamatan.kabupaten")
        ->whereIn('kecamatan_id', $kecamatans->pluck('id'))
        ->whereIn('id', function ($query) use ($kecamatans) {
            $query->selectRaw('MAX(id)')
                ->from('monthly_progress') // Changed from 'monthly_progresses' to 'monthly_progress'
                ->whereIn('kecamatan_id', $kecamatans->pluck('id'))
                ->groupBy('kecamatan_id');
        });

    $latestProgress = $latestProgressQuery->get();

    // Sum only the latest capaian from each kecamatan
    $totalCapaian = $latestProgress->sum("capaian_kbpp");
    $totalCapaianMkjp = $latestProgress->sum("capaian_mkjp");

    // Monthly chart data - group by month and sum capaian for that month
    $monthlyProgressQuery = MonthlyProgress::with("kecamatan.kabupaten");

    if ($kabupatenId) {
        $monthlyProgressQuery->whereHas(
            "kecamatan",
            fn($q) => $q->where("kabupaten_id", $kabupatenId),
        );
    }

    if ($kecamatanId) {
        $monthlyProgressQuery->where("kecamatan_id", $kecamatanId);
    }

    $monthlyProgress = $monthlyProgressQuery->get();

    $monthlyData = $monthlyProgress
        ->groupBy("month")
        ->map(fn($rows) => $rows->sum("capaian_kbpp"))
        ->toArray();

    return response()->json([
        'allKabupatens' => $allKabupatens,
        'allKecamatans' => $allKecamatans,
        'kabupatenId' => $kabupatenId,
        'kecamatanId' => $kecamatanId,
        'totalTarget' => $totalTarget,
        'totalCapaian' => $totalCapaian,
        'totalTargetMkjp' => $totalTargetMkjp,
        'totalCapaianMkjp' => $totalCapaianMkjp,
        'monthlyData' => $monthlyData,
    ]);
})->name("api.dashboard-data");

Route::get("/data-capaian", function (Request $request) {
    $kabupatenId = $request->input("kabupaten_id");
    $kecamatanId = $request->input("kecamatan_id");

    $allKabupatens = Kabupaten::orderBy("name")->get();

    // Load kecamatans for dropdown
    $kecamatansQuery = Kecamatan::query();
    if ($kabupatenId) {
        $kecamatansQuery->where("kabupaten_id", $kabupatenId);
    }
    $allKecamatans = $kecamatansQuery->orderBy("name")->get();

    // Get kecamatan targets based on filters
    $kecamatanQuery = Kecamatan::query();
    if ($kabupatenId) {
        $kecamatanQuery->where("kabupaten_id", $kabupatenId);
    }
    if ($kecamatanId) {
        $kecamatanQuery->where("id", $kecamatanId);
    }
    $kecamatans = $kecamatanQuery->get();

    // Calculate totals from kecamatan targets (not sum from progress)
    $totalTarget = $kecamatans->sum("target_kbpp");
    $totalTargetMkjp = $kecamatans->sum("target_mkjp");

    // Get latest progress for each kecamatan using the correct table name
    $latestProgressQuery = MonthlyProgress::with("kecamatan.kabupaten")
        ->whereIn('kecamatan_id', $kecamatans->pluck('id'))
        ->whereIn('id', function ($query) use ($kecamatans) {
            $query->selectRaw('MAX(id)')
                ->from('monthly_progress') // Changed from 'monthly_progresses' to 'monthly_progress'
                ->whereIn('kecamatan_id', $kecamatans->pluck('id'))
                ->groupBy('kecamatan_id');
        });

    $latestProgress = $latestProgressQuery->get();

    // Sum only the latest capaian from each kecamatan
    $totalCapaian = $latestProgress->sum("capaian_kbpp");
    $totalCapaianMkjp = $latestProgress->sum("capaian_mkjp");

    // Monthly chart data - group by month and sum capaian for that month
    $monthlyProgressQuery = MonthlyProgress::with("kecamatan.kabupaten");

    if ($kabupatenId) {
        $monthlyProgressQuery->whereHas(
            "kecamatan",
            fn($q) => $q->where("kabupaten_id", $kabupatenId),
        );
    }

    if ($kecamatanId) {
        $monthlyProgressQuery->where("kecamatan_id", $kecamatanId);
    }

    $monthlyProgress = $monthlyProgressQuery->get();

    $monthlyData = $monthlyProgress
        ->groupBy("month")
        ->map(fn($rows) => $rows->sum("capaian_kbpp"))
        ->toArray();

    return view(
        "pages.partsials.data-capaian",
        compact(
            "allKabupatens",
            "allKecamatans",
            "kabupatenId",
            "kecamatanId",
            "totalTarget",
            "totalCapaian",
            "totalTargetMkjp",
            "totalCapaianMkjp",
            "monthlyData",
        ),
    );
})->name("data-capaian");

// Dynamic kecamatan for dropdown
Route::get("/get-kecamatan/{kabupatenId}", function ($kabupatenId) {
    return response()->json(
        Kecamatan::where("kabupaten_id", $kabupatenId)
            ->orderBy("name")
            ->get(["id", "name"]),
    );
});
Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );

    Route::get("/data-capaian-kbpp", function (Request $request) {
        // ----------- Kabupaten Table ------------
        $kabupatens = Kabupaten::query()->orderBy("name")->paginate(15);

        // ----------- Latest month ----------
        // Get the latest monthly_progress record
        $latestProgress = MonthlyProgress::orderByDesc("id")->first();
        $latest_month = $latestProgress?->month ?? null;

        // ----------- Kecamatan Table (filter by kabupaten_id_kec) ------------
        $kabupatenFilterForKecamatan = $request->input("kabupaten_id_kec");

        $kecamatansQuery = Kecamatan::with("kabupaten")
            ->withSum(
                [
                    "monthlyProgress as capaian_kbpp" => function ($q) use (
                        $latest_month,
                    ) {
                        if ($latest_month) {
                            $q->where("month", $latest_month);
                        }
                    },
                ],
                "capaian_kbpp",
            )
            ->withSum(
                [
                    "monthlyProgress as capaian_mkjp" => function ($q) use (
                        $latest_month,
                    ) {
                        if ($latest_month) {
                            $q->where("month", $latest_month);
                        }
                    },
                ],
                "capaian_mkjp",
            );

        if ($kabupatenFilterForKecamatan) {
            $kecamatansQuery->where(
                "kabupaten_id",
                $kabupatenFilterForKecamatan,
            );
        }

        $kecamatans = $kecamatansQuery
            ->orderBy("name")
            ->paginate(15, ["*"], "kecamatan_page");

        // ----------- Monthly Progress Table (independent filters) ------------
        $kabupatenId = $request->input("kabupaten_id");
        $kecamatanId = $request->input("kecamatan_id");

        $progressQuery = MonthlyProgress::query()->with([
            "kecamatan.kabupaten",
        ]);

        if ($kabupatenId) {
            $progressQuery->whereHas("kecamatan", function ($q) use (
                $kabupatenId,
            ) {
                $q->where("kabupaten_id", $kabupatenId);
            });
        }

        if ($kecamatanId) {
            $progressQuery->where("kecamatan_id", $kecamatanId);
        }

        $progress = $progressQuery->paginate(15, ["*"], "progress_page");

        // ----------- Dropdown data ------------
        $allKabupatens = Kabupaten::orderBy("name")->get();

        $allKecamatans = Kecamatan::query()
            ->when(
                $kabupatenId,
                fn($q) => $q->where("kabupaten_id", $kabupatenId),
            )
            ->orderBy("name")
            ->get();

        // ----------- Return view ------------
        return view(
            "pages.data-capaian-kbpp",
            compact(
                "kabupatens",
                "kecamatans",
                "progress",
                "allKabupatens",
                "allKecamatans",
                "kabupatenFilterForKecamatan",
                "kabupatenId",
                "kecamatanId",
                "latest_month", // Pass latest month to Blade
            ),
        );
    })->name("data-capaian-kbpp");

    // Export routes
    Route::get("/kabupatens/export", function () {
        return Excel::download(new KabupatensExport(), "kabupatens.xlsx");
    })->name("kabupatens.export");

    Route::get("/kecamatans/export", function () {
        return Excel::download(new KecamatansExport(), "kecamatans.xlsx");
    })->name("kecamatans.export");

    Route::get("/monthly-progress/export", function (
        \Illuminate\Http\Request $request,
    ) {
        return Excel::download(
            new MonthlyProgressExport($request),
            "monthly_progress.xlsx",
        );
    })->name("monthly-progress.export");

    Route::prefix('kie-kbpp')->name('kie-kbpp.')->group(function () {
        Route::get('/', [KieKbppController::class, 'index'])->name('index');
        Route::post('/', [KieKbppController::class, 'store'])->name('store');
        Route::put('/{kieKbpp}', [KieKbppController::class, 'update'])->name('update');
        Route::delete('/{kieKbpp}', [KieKbppController::class, 'destroy'])->name('destroy');
        Route::get('/{kieKbpp}/download', [KieKbppController::class, 'download'])->name('download');
    });
    Route::resource('pergerakan-kbpp', PergerakanKbppController::class)->except(['show', 'create', 'edit']);

    Route::resource("kabupatens", KabupatenController::class);
    Route::resource("kecamatans", KecamatanController::class);
    Route::resource("monthly-progress", MonthlyProgressController::class);
});

require __DIR__ . "/auth.php";
