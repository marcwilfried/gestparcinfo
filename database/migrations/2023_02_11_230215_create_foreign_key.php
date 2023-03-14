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
        Schema::table('appareils', function (Blueprint $table) {
            $table->foreign('stock_id')
            ->references('id')
            ->on('stocks')
            ->onDelete('set null')
            ->onUpdate('cascade');

            $table->foreign('type_appareil_id')
            ->references('id')
            ->on('type_appareils')
            ->onDelete('set null')
            ->onUpdate('cascade');

            $table->foreign('service_id')
            ->references('id')
            ->on('services')
            ->onDelete('set null')
            ->onUpdate('cascade');
        });

        Schema::table('pannes', function (Blueprint $table) {
            $table->foreign('intervention_id')
            ->references('id')
            ->on('interventions')
            ->onDelete('set null')
            ->onUpdate('cascade');

            $table->foreign('appareil_id')
            ->references('id')
            ->on('appareils')
            ->onDelete('set null')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreign_key');
    }
};
