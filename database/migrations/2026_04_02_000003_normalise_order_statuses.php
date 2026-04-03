<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Map legacy status values to the new 3-value OrderStatus enum.
     *
     * pending    → pending   (no change)
     * processing → pending   (was in progress but not yet shipped)
     * shipped    → shipped   (no change)
     * delivered  → received  (closest equivalent)
     * cancelled  → pending   (edge case: keep visible as active for review)
     */
    public function up(): void
    {
        DB::table('orders')->where('status', 'processing')->update(['status' => 'pending']);
        DB::table('orders')->where('status', 'delivered')->update(['status' => 'received']);
        DB::table('orders')->where('status', 'cancelled')->update(['status' => 'pending']);
    }

    public function down(): void
    {
        // No safe rollback: original values per order are no longer known.
    }
};
