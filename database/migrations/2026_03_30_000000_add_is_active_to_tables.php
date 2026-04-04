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
        // Add is_active to news_categories (after color)
        if (Schema::hasTable('news_categories') && !Schema::hasColumn('news_categories', 'is_active')) {
            Schema::table('news_categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('color');
            });
        }

        // Add is_active to service_categories (after icon)
        if (Schema::hasTable('service_categories') && !Schema::hasColumn('service_categories', 'is_active')) {
            Schema::table('service_categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('icon');
            });
        }

        // Add is_active to complaint_categories (after icon)
        if (Schema::hasTable('complaint_categories') && !Schema::hasColumn('complaint_categories', 'is_active')) {
            Schema::table('complaint_categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('icon');
            });
        }

        // Add is_active to ppid_categories (after order)
        if (Schema::hasTable('ppid_categories') && !Schema::hasColumn('ppid_categories', 'is_active')) {
            Schema::table('ppid_categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('order');
            });
        }

        // Add is_active to periodic_informations (after is_published)
        if (Schema::hasTable('periodic_informations') && !Schema::hasColumn('periodic_informations', 'is_active')) {
            Schema::table('periodic_informations', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_published');
            });
        }

        // Add is_active to potentials (after is_published)
        if (Schema::hasTable('potentials') && !Schema::hasColumn('potentials', 'is_active')) {
            Schema::table('potentials', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_published');
            });
        }

        // Add is_active to infographics (after is_published)
        if (Schema::hasTable('infographics') && !Schema::hasColumn('infographics', 'is_active')) {
            Schema::table('infographics', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_published');
            });
        }

        // Add is_active to ppid_documents (after year)
        if (Schema::hasTable('ppid_documents') && !Schema::hasColumn('ppid_documents', 'is_active')) {
            Schema::table('ppid_documents', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('year');
            });
        }

        // Add is_active to pages (after is_published)
        if (Schema::hasTable('pages') && !Schema::hasColumn('pages', 'is_active')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_published');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_categories', function (Blueprint $table) {
            if (Schema::hasColumn('news_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('service_categories', function (Blueprint $table) {
            if (Schema::hasColumn('service_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('complaint_categories', function (Blueprint $table) {
            if (Schema::hasColumn('complaint_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('ppid_categories', function (Blueprint $table) {
            if (Schema::hasColumn('ppid_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('periodic_informations', function (Blueprint $table) {
            if (Schema::hasColumn('periodic_informations', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('potentials', function (Blueprint $table) {
            if (Schema::hasColumn('potentials', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('infographics', function (Blueprint $table) {
            if (Schema::hasColumn('infographics', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('ppid_documents', function (Blueprint $table) {
            if (Schema::hasColumn('ppid_documents', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
