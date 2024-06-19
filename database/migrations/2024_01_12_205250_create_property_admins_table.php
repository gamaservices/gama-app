<?php

use App\Enums\AccountType;
use App\Enums\PropertyAdminType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->constrained('addresses');

            $table->string('name', 255);
            $table->string('document', 31);
            $table->string('account_number', 63);
            $table->string('account_entity', 255);
            $table->enum('account_type', AccountType::values());
            $table->enum('type', PropertyAdminType::values());
            $table->string('email1', 255);
            $table->string('email2', 255)->nullable();
            $table->string('phone1', 31);
            $table->string('phone2', 31)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_admins');
    }
};
