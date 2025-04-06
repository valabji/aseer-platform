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
        Schema::table('detainees', function (Blueprint $table) {
            $table->date('martyr_date')->nullable();
            $table->string('martyr_place')->nullable();
            $table->text('martyr_reason')->nullable();
            $table->text('martyr_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detainees', function (Blueprint $table) {
            $table->dropColumn(['martyr_date', 'martyr_place', 'martyr_reason', 'martyr_notes']);
        });
    }
};
