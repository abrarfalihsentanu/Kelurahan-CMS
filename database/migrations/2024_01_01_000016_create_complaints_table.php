<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('complaint_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('subject');
            $table->text('description');
            $table->string('location')->nullable();
            $table->json('attachments')->nullable();
            $table->string('status')->default('pending'); // pending, verified, in_progress, resolved, rejected
            $table->text('response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
