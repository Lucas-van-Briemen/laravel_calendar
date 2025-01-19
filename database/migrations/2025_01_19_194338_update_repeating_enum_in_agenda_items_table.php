<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE agenda_items CHANGE COLUMN repeating repeating ENUM('never', 'daily', 'weekly', 'monthly', 'yearly', 'weekdays') NOT NULL DEFAULT 'never'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda_items', function (Blueprint $table) {
            //
        });
    }
};
