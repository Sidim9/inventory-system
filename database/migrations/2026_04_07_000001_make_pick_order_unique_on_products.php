<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Products with pick_order = 0 have no assigned pick position — set to null
        DB::table('products')->where('pick_order', 0)->update(['pick_order' => null]);

        // For any duplicate pick_order values, keep the product with the highest id
        // (the most recently created) and set the others to null
        $duplicates = DB::table('products')
            ->select('pick_order', DB::raw('MAX(id) as keep_id'))
            ->whereNotNull('pick_order')
            ->groupBy('pick_order')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('products')
                ->where('pick_order', $dup->pick_order)
                ->where('id', '!=', $dup->keep_id)
                ->update(['pick_order' => null]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->integer('pick_order')->nullable()->default(null)->change();
            $table->unique('pick_order');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['pick_order']);
            $table->integer('pick_order')->nullable(false)->default(0)->change();
        });

        DB::table('products')->whereNull('pick_order')->update(['pick_order' => 0]);
    }
};
