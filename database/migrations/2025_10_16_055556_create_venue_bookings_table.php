<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venue_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->date('event_date');
            $table->integer('guests');
            $table->timestamps();
            $table->unique(['venue_id', 'event_date']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_bookings');
    }
};
