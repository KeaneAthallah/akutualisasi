<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("monthly_progress", function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId("kecamatan_id")
                ->constrained()
                ->onDelete("cascade");
            $table->string("month");
            $table->integer("capaian_kbpp")->default(0);
            $table->integer("capaian_mkjp")->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("monthly_progress");
    }
};
