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
        Schema::create("pdf_documents", function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('no_surat');
            $table->text('file_path')->nullable(); // Store file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("pdf_documents");
    }
};
