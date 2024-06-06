<?php

use App\Models\Address;
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
            $table->string('contract')->nullable();
            $table->string('matricula_inmobiliaria');
            $table->string('codigo_catastral')->nullable();
            $table->string('escritura')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_horizontal')->nullable();
            $table->float('area')->nullable();
            $table->string('conservation_state')->nullable();
            $table->string('owner')->nullable();
            $table->tinyInteger('ownership_percentage')->nullable();

            $table->timestamp('disable_at')->nullable();
            $table->timestamp('acquired_at')->nullable();
            $table->timestamps();

            $table->softDeletes();

            $table->foreignIdFor(Address::class);
            $table->foreignId('notary_office_id')->nullable()->constrained('notary_offices');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
