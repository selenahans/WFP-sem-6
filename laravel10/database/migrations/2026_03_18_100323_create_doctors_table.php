<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id(); 
            $table->string('name'); 
            $table->string('specialist'); 
            $table->string('license_number')->unique(); 
            $table->string('phone_number')->nullable();
            $table->text('bio')->nullable(); 
            $table->string('photo')->nullable();
            $table->integer('experience_years')->default(0);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();             
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};