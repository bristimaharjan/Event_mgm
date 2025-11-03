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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vendor_id'); // Vendor reference
        $table->string('event_name');
        $table->date('event_date');
        $table->string('venue');
        $table->text('description');
        $table->string('image'); // store the filename/path
        $table->decimal('price', 10, 2);
        $table->integer('available_seats');
        $table->timestamps();

        // Foreign key constraint
        $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
    });
}

};
