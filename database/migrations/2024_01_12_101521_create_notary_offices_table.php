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
            $table->tinyInteger('number');
            $table->timestamps();
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('city_id')->nullable()->constrained('cities');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notary_offices');
    }
};
