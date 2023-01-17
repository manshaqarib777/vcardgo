<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardsNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->text('registration_commune')->nullable();
            $table->text('inspection_commune')->nullable();
            $table->text('inspection_commune_new')->nullable();
            $table->text('parking_commune')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->dropColumn('registration_commune');
            $table->dropColumn('inspection_commune');
            $table->dropColumn('inspection_commune_new');
            $table->dropColumn('parking_commune');
        });
    }
}
