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
        Schema::table('ppid_requests', function (Blueprint $table) {
            $table->string('type')->default('permohonan')->after('ticket_number');
            $table->string('reference_number')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppid_requests', function (Blueprint $table) {
            $table->dropColumn(['type', 'reference_number']);
        });
    }
};
