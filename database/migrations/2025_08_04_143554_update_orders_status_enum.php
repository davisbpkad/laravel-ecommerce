<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing records to use English status values
        DB::statement("UPDATE orders SET status = 'processing' WHERE status = 'diproses'");
        DB::statement("UPDATE orders SET status = 'shipped' WHERE status = 'dikirim'");
        DB::statement("UPDATE orders SET status = 'delivered' WHERE status = 'selesai'");

        // Drop the existing enum constraint and recreate with English values
        DB::statement("ALTER TABLE orders DROP CONSTRAINT orders_status_check");
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('pending', 'processing', 'shipped', 'delivered', 'cancelled'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert English status values back to Indonesian
        DB::statement("UPDATE orders SET status = 'diproses' WHERE status = 'processing'");
        DB::statement("UPDATE orders SET status = 'dikirim' WHERE status = 'shipped'");
        DB::statement("UPDATE orders SET status = 'selesai' WHERE status = 'delivered'");

        // Drop the constraint and recreate with Indonesian values
        DB::statement("ALTER TABLE orders DROP CONSTRAINT orders_status_check");
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('pending', 'diproses', 'dikirim', 'selesai'))");
    }
};
