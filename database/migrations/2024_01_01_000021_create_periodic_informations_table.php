<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('periodic_informations')) {
            Schema::create('periodic_informations', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->text('content')->nullable();
                $table->string('file')->nullable();
                $table->string('file_type')->nullable();
                $table->integer('file_size')->nullable();
                $table->string('category')->nullable();
                $table->string('year')->nullable();
                $table->integer('downloads')->default(0);
                $table->integer('order')->default(0);
                $table->boolean('is_published')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('periodic_informations');
    }
};
