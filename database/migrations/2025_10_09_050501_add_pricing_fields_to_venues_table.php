<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->enum('price_type', ['per_person', 'per_day', 'per_hour', 'package'])->default('per_day');
            $table->decimal('base_price', 10, 2)->nullable()->change();
            $table->text('package_details')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            //
        });
    }
};
