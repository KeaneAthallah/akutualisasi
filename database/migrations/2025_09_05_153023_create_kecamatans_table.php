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
        Schema::create("kecamatans", function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId("kabupaten_id")
                ->constrained()
                ->onDelete("cascade");
            $table->string("name");
            $table->year("year");
            $table->integer("target_kbpp")->default(0);
            $table->integer("target_mkjp")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("kecamatans");
    }
};
