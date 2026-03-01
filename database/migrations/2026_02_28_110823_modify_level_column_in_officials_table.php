<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, change column type from integer to string
        Schema::table('officials', function (Blueprint $table) {
            $table->string('level')->default('staff')->change();
        });

        // Then, convert existing integer values to their string equivalents
        DB::table('officials')->where('level', '0')->update(['level' => 'lurah']);
        DB::table('officials')->where('level', '1')->update(['level' => 'sekretaris']);
        DB::table('officials')->where('level', '2')->update(['level' => 'kasi']);
        DB::table('officials')->where('level', '3')->update(['level' => 'staff']);
    }

    public function down(): void
    {
        // Convert string values back to integers
        DB::table('officials')->where('level', 'lurah')->update(['level' => '0']);
        DB::table('officials')->where('level', 'sekretaris')->update(['level' => '1']);
        DB::table('officials')->where('level', 'kasi')->update(['level' => '2']);
        DB::table('officials')->where('level', 'staff')->update(['level' => '3']);

        // Change column type back to integer
        Schema::table('officials', function (Blueprint $table) {
            $table->integer('level')->default(0)->change();
        });
    }
};
