<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_services', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('company');
            $table->boolean('is_domiciled');
            $table->timestamps();

            $table->foreignId('property_id')->constrained('properties');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_services');
    }
};
