<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('line_jalurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('start_id')->constrained('point_start')->onDelete('cascade');
            $table->foreignId('wisata_id')->constrained('point_wisata')->onDelete('cascade');
            $table->geometry('geom', 'MultiLineString', 4326);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_jalurs');
    }
};
