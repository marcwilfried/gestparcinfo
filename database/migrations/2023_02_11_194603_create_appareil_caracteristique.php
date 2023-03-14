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
        Schema::create('appareil_caracteristique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appareil_id')
                  ->nullable()
                  ->constrained('appareils')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreignId('caracteristique_id')
                    ->nullable()
                    ->constrained('caracteristiques')
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
        Schema::dropIfExists('appareil_caracteristique');
    }
};
