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
        Schema::table('stocks', function (Blueprint $table) {

            // Drop foreign key first
            $table->dropForeign(['subscription_id']);

            // Then drop column
            $table->dropColumn('subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->foreignId('subscription_id')
              ->constrained()
              ->onDelete('cascade');
        });
    }
};
