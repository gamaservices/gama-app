<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('base_address', 255);
            $table->string('neighborhood', 255)->nullable();
            $table->string('building_name', 255)->nullable();
            $table->string('apartment', 255)->nullable();
            $table->json('observations')->nullable();
            $table->geography('location')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->foreignIdFor(City::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
