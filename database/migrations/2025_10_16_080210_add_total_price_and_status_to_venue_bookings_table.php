<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('venue_bookings', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->after('guests')->default(0);
            $table->enum('status', ['paid', 'unpaid'])->after('total_price')->default('unpaid');
        });
    }

    public function down(): void
    {
        Schema::table('venue_bookings', function (Blueprint $table) {
            $table->dropColumn(['total_price', 'status']);
        });
    }
};
