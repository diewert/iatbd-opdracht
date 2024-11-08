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
        Schema::create('huisdieren', function (Blueprint $table) {
            $table->id(); // pk id van huisdier
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relatie naar een eigenaar
            $table->string('naam'); // Naam van het huisdier
            $table->string('soort'); // Ras van het huisdier
            $table->decimal('uurtarief', 8, 2); // Uurtarief dat wordt betaald om op het huisdier te passen
            $table->date('begin_datum'); //datum vanaf wanneer er op het huisdier gepast moet worden
            $table->date('eind_datum'); //datum tot wanneer er op het huisdier gepast moet worden
            $table->string('achtergrond_informatie'); // Achtergrond informatie over het huisdier
            $table->string('foto')->nullable(); //Eventuele foto van huisdier
            $table->timestamps(); // Automatische velden voor created_at en updated_at
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huisdieren');
        //
    }
};
