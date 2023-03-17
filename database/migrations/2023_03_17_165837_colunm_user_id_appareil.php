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
            $table->unsignedInteger('user_id')->nullable();
            $table->string('userapp', 255)->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('service_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appareils', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('service_id');
        });
    }
};
