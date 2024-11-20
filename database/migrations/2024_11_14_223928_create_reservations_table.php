<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

/**
 * The function creates a database table for reservations with columns for reserved_at timestamp,
 * duration time, status enum, and a foreign key for resources.
 */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->timestamp('reserved_at');
            $table->time('duration');
            $table->enum('status', ['confirmed', 'pending', 'cancelled'])->default('confirmed');
            $table->foreignId('resources_id')->constrained()->onDelete('cascade');
        });
    }

/**
 * The down() function in PHP drops the 'reservations' table from the database schema.
 */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
