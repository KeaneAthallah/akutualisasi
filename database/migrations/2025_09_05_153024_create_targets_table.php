<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("targets", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("kecamatan_id")
                ->constrained()
                ->onDelete("cascade");
            $table->year("year");
            $table->integer("target_kbpp")->default(0);
            $table->integer("capaian_kbpp")->default(0);
            $table->decimal("capaian_kbpp_percent", 5, 2)->default(0.0);
            $table->integer("target_mkjp")->default(0);
            $table->integer("capaian_mkjp")->default(0);
            $table->decimal("capaian_mkjp_percent", 5, 2)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("targets");
    }
};
