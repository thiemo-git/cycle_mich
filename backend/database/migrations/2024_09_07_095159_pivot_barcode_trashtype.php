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
        Schema::create('barcode_trashtype', function (Blueprint $table) {
            $table->foreignId('barcode_id')->references('id')->on('barcodes')->onDelete('cascade');
            $table->foreignId('trashtype_id')->references('id')->on('trashtypes')->onDelete('cascade');

            $table->unique(array('barcode_id','trashtype_id'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode_trashtype');
    }
};
