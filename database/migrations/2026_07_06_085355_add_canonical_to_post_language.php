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
        if (!Schema::hasColumn('post_language', 'canonical')) {
            Schema::table('post_language', function (Blueprint $table) {
                $table->string('canonical')->nullable()->after('meta_description');
            });
        }

        // Sync existing canonical values from the routers table
        $routers = \Illuminate\Support\Facades\DB::table('routers')
            ->where('controllers', 'App\Http\Controllers\Frontend\PostController')
            ->get();

        foreach ($routers as $router) {
            \Illuminate\Support\Facades\DB::table('post_language')
                ->where('post_id', $router->module_id)
                ->where('language_id', $router->language_id)
                ->update(['canonical' => $router->canonical]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('post_language', 'canonical')) {
            Schema::table('post_language', function (Blueprint $table) {
                $table->dropColumn('canonical');
            });
        }
    }
};
