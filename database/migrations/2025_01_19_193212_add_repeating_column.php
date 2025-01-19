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
        Schema::table('agenda_items', function (Blueprint $table) {
            //
            $table->enum('repeating', ['never', 'daily', 'weekly', 'monthly', 'yearly'])->default('never');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda_items', function (Blueprint $table) {
            //
            $table->dropColumn('repeating');
        });
    }
};
