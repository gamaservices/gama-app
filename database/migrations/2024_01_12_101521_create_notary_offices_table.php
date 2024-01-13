<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notary_offices', function (Blueprint $table) {
            $table->id();
            $table->char('number', 2);
            $table->timestamps();
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('city_id')->constrained('cities');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notary_offices');
    }
};
