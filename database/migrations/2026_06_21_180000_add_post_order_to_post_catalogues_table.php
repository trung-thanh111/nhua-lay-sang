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
        Schema::table('post_catalogues', function (Blueprint $table) {
            $table->string('post_order')->default('latest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_catalogues', function (Blueprint $table) {
            $table->dropColumn('post_order');
        });
    }
};
