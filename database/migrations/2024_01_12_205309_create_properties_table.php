<?php

use App\Models\Address;
use App\Models\Bank;
use App\Models\NotaryOffice;
use App\Models\PropertyAdmin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Address::class);
            $table->foreignIdFor(NotaryOffice::class);
            $table->foreignIdFor(Bank::class);
            $table->foreignIdFor(PropertyAdmin::class);

            $table->string('contract')->nullable();
            $table->string('matricula_inmobiliaria');
            $table->string('codigo_catastral')->nullable();
            $table->string('escritura')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_horizontal')->nullable();
            $table->float('area')->nullable();
            $table->string('conservation_state')->nullable();
            $table->tinyInteger('bank_ownership_percentage')->nullable();

            $table->timestamp('disable_at')->nullable();
            $table->timestamp('acquired_at')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
