<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_categories', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('news_categories', 'icon')) {
                $table->string('icon')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('news_categories', 'description')) {
                $table->text('description')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('news_categories', 'order')) {
                $table->integer('order')->default(0)->after('description');
            }
            if (!Schema::hasColumn('news_categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('order');
            }
            // Drop color column if it exists and we're moving to icon
            if (Schema::hasColumn('news_categories', 'color')) {
                $table->dropColumn('color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news_categories', function (Blueprint $table) {
            if (Schema::hasColumn('news_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('news_categories', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('news_categories', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('news_categories', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
