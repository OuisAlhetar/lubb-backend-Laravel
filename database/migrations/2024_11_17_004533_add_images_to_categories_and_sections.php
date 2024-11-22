<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToCategoriesAndSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('category_image')->nullable()->after('name'); // Add category_image column
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->string('section_image')->nullable()->after('name'); // Add section_image column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('category_image'); // Drop category_image column
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('section_image'); // Drop section_image column
        });
    }
}