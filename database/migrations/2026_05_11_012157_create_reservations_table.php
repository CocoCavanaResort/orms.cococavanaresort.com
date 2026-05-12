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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->enum('stay_type', ['overnight', 'day_tour']);
            $table->integer('number_of_adults')->default(1);
            $table->integer('number_of_kids')->default(0);
            $table->integer('number_of_children')->default(0);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
