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
        Schema::create('draft_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 255)->unique();
            $table->string('manufacturer_name', 255);
            $table->foreignId('category_id')->constrained('categories');
            $table->decimal('sales_price', 10, 2);
            $table->decimal('mrp', 10, 2);
            $table->text('molecule_string');
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_discontinued')->default(false);
            $table->boolean('is_assured')->default(false);
            $table->boolean('is_refridgerated')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->boolean('is_active')->default(true);
            $table->foreignId('deleted_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_products');
    }
};
