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
        Schema::create('recommend_customers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stock_recommend_id')
                ->constrained('stock_recommends')
                ->cascadeOnDelete(); 

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['stock_recommend_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommend_customers');
    }
};
