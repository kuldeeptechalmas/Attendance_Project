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
        Schema::create('checkinout', function (Blueprint $table) {
            $table->id();
            $table->time("check_in_time")->default(null);
            $table->time("check_out_time")->default(null);
            $table->bigInteger("attandance_id");
            $table->foreign("attandance_id")->references("id")->on("attendance");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkinout');
    }
};
