<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

/**
 * The function creates a database table named 'resources' with columns for id, name, description, and
 * capacity.
 */
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description', 200)->nullable();
            $table->integer('capacity');
        });
    }

/**
 * The down() function in PHP drops the 'resources' table from the database schema.
 */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
