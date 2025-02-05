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
        Schema::create('product_molecules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draft_product_id')->constrained('draft_products');
            $table->foreignId('molecule_id')->constrained('molecules');
            // $table->timestamps();
            $table->unique(['draft_product_id', 'molecule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_product_molecules');
    }
};
