<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('customer')->default('Banco de Bogotá');
            $table->string('contract');
            $table->string('matricula_inmobiliaria');
            $table->string('codigo_catastral');
            $table->string('escritura');
            $table->string('neighborhood')->nullable();
            $table->string('address');
            $table->enum('type', ['rural', 'urban']);
            $table->boolean('is_horizontal');
            $table->float('area');
            $table->enum('conservation_state', ['good', 'normal', 'bad']);
            $table->string('owner');
            $table->tinyInteger('ownership_percentage');

            $table->timestamp('disable_at')->nullable();
            $table->timestamp('acquired_at');
            $table->timestamps();

            $table->softDeletes();

            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('notary_office_id')->constrained('notary_offices');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
