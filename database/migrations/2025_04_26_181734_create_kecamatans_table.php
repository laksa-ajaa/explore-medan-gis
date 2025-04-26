<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('kota')->nullable();
            $table->string('prov')->nullable();
            $table->decimal('shape_leng', 20, 10)->nullable();
            $table->decimal('shape_area', 20, 10)->nullable();
            $table->geometry('geom')->nullable(); // <<< bikin geometry biasa dulu
            $table->timestamps();
        });

        // Baru alter supaya geom jadi MultiPolygon 4326
        DB::statement('ALTER TABLE kecamatans ALTER COLUMN geom TYPE geometry(MultiPolygonZ, 4326)');
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
