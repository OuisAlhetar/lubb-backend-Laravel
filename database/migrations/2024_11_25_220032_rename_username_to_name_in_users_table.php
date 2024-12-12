<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         // Add the new 'name' column
    //         $table->string('name')->nullable();
    //     });

    //     // Populate the 'name' column with data from 'username'
    //     DB::statement('UPDATE users SET name = username');

    //     Schema::table('users', function (Blueprint $table) {
    //         // Drop the old 'username' column
    //         $table->dropColumn('username');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         // Re-add the 'username' column
    //         $table->string('username')->nullable();
    //     });

    //     // Populate the 'username' column with data from 'name'
    //     DB::statement('UPDATE users SET username = name');

    //     Schema::table('users', function (Blueprint $table) {
    //         // Drop the 'name' column
    //         $table->dropColumn('name');
    //     });
    // }
};
