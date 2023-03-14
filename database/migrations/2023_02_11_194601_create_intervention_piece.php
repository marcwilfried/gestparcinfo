<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervention_piece', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')
                  ->nullable()
                  ->constrained('interventions')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreignId('piece_id')
                  ->nullable()
                  ->constrained('pieces')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->double('quantite', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intervention_piece');
    }
};
