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
        Schema::table('agenda_items', function (Blueprint $table) {
            $table->dropColumn('email_sent');
            $table->dateTime('should_send_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('agenda_items', function (Blueprint $table) {
            $table->boolean('email_sent');
            $table->dropColumn('should_send_at');
        });
    }
};
