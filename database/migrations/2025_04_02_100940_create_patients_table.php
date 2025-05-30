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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surnames');
            $table->date('birthdate');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('document_type', ['DNI', 'NIE', 'Pasaporte'])->nullable();
            $table->string('document_number')->nullable();
            // tutor
            $table->string('tutor_name')->nullable();
            $table->string('tutor_email')->nullable();
            $table->enum('tutor_document_type', ['DNI', 'NIE', 'Pasaporte'])->nullable();
            $table->string('tutor_document_number')->nullable();
            $table->string('tutor_phone')->nullable();
            $table->timestamps();
            $table->unique(['name', 'surnames', 'birthdate', 'tutor_document_type', 'tutor_document_number'], 'unique_patient_by_tutor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
