<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('service_categories', 'description')) {
                $table->text('description')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('service_categories', 'order')) {
                $table->integer('order')->default(0)->after('description');
            }
            if (!Schema::hasColumn('service_categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_categories', function (Blueprint $table) {
            if (Schema::hasColumn('service_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('service_categories', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('service_categories', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
