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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->decimal('price', 10, 2);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->boolean('in_stock')->default(true);
            $table->float('rating', 3, 2)->default(0);
            $table->timestamps();

            // Indexes for performance
            $table->index('price');
            $table->index('category_id');
            $table->index('rating');
            $table->index('created_at');
            $table->index('in_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
