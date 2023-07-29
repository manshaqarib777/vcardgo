<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardAddSomeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->text('registration_driver_name')->nullable();
            $table->text('registration_driver_address')->nullable();
            $table->text('registration_driver_emergency_contact_no')->nullable();
            $table->text('registration_driver_extra_field')->nullable();
            $table->text('registration_driver_country')->nullable();
            $table->text('registration_driver_state')->nullable();
            $table->text('registration_driver_city')->nullable();
            $table->text('registration_driver_district')->nullable();
            $table->text('registration_driver_commune')->nullable();
            $table->text('registration_driver')->nullable();
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
            $table->dropColumn('registration_driver_name');
            $table->dropColumn('registration_driver_address');
            $table->dropColumn('registration_driver_emergency_contact_no');
            $table->dropColumn('registration_driver_extra_field');
            $table->dropColumn('registration_driver_country');
            $table->dropColumn('registration_driver_state');
            $table->dropColumn('registration_driver_city');
            $table->dropColumn('registration_driver_district');
            $table->dropColumn('registration_driver_commune');
            $table->dropColumn('registration_driver');
        });
    }
}
