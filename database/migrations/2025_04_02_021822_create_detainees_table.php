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
        Schema::create('detainees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('location')->nullable();
            $table->date('detention_date')->nullable();
            $table->enum('status', ['detained', 'missing', 'released', 'martyr'])->default('detained');
            $table->string('detaining_authority')->nullable();
            $table->string('prison_name')->nullable();
            $table->boolean('is_forced_disappearance')->default(false);
            $table->string('family_contact_name')->nullable();
            $table->string('family_contact_phone')->nullable();
            $table->text('notes')->nullable();
            $table->string('source')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        }


        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detainees');
    }
};
