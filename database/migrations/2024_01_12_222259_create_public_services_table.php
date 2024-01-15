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
            $table->foreignId('property_id')->constrained('properties');
            $table->string('type');
            $table->string('company');
            $table->boolean('is_domiciled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_services');
    }
};
