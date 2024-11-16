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
        Schema::table('most_viewed', function (Blueprint $table) {
            $table->unsignedBigInteger('view_count')->default(0)->after('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('most_viewed', function (Blueprint $table) {
            $table->dropColumn('view_count');
        });
    }
};
