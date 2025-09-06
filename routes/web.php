<?php

use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MonthlyProgressController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get("/dashboard", function () {
    return view("dashboard");
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");

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

    Route::get("/data-capaian-kbpp", function () {
        return view("pages.data-capaian-kbpp");
    })->name("data-capaian-kbpp");
    Route::get("/advokasi-kbpp", function () {
        return view("pages.advokasi-kbpp");
    })->name("advokasi-kbpp");
    Route::get("/kie-kbpp", function () {
        return view("pages.kie-kbpp");
    })->name("kie-kbpp");
    Route::get("/pergerakan-kbpp", function () {
        return view("pages.pergerakan-kbpp");
    })->name("pergerakan-kbpp");

    Route::resource("kabupaten-kota", KabupatenController::class);
    Route::resource("kecamatan", KecamatanController::class);
    Route::resource("data", MonthlyProgressController::class);
});

require __DIR__ . "/auth.php";
