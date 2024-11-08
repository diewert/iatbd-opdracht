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
        Schema::create('passen_aanvragen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oppasser_id'); // Wie past op?
            $table->unsignedBigInteger('huisdier_id'); // Op welk huisdier?
            $table->unsignedBigInteger('eigenaar_id'); // Eigenaar van het huisdier
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Status van de aanvraag
            $table->timestamps();
        
            // Relaties
            $table->foreign('oppasser_id')->references('id')->on('oppassers')->onDelete('cascade');
            $table->foreign('huisdier_id')->references('id')->on('huisdieren')->onDelete('cascade');
            $table->foreign('eigenaar_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passen_aanvragen');
    }
};
