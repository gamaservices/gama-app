<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number');
            $table->string('type');
            $table->string('company');
            $table->timestamp('start_at');
            $table->timestamp('expired_at');
            $table->timestamps();

            $table->foreignId('property_id')->constrained('properties');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
