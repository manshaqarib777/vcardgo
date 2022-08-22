<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardsAddRegistrationsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->string('registration_address')->nullable();
            $table->string('registration_chassis_no')->nullable();
            $table->string('registration_vin_no')->nullable();
            $table->string('registration_vehicle_model')->nullable();
            $table->string('registration_vehicle_color')->nullable();
            $table->string('registration_vehicle_year')->nullable();
            $table->string('registration_plate_no')->nullable();
            $table->string('registration_country')->nullable();
            $table->string('registration_state')->nullable();
            $table->string('registration_city')->nullable();
            $table->string('registration_district')->nullable();
            $table->string('registration_emergency_contact_no')->nullable();
            $table->string('registration_ar_no')->nullable();
            $table->string('registration_pcn_no')->nullable();



            $table->string('inspection_address')->nullable();
            $table->string('inspection_chassis_no')->nullable();
            $table->string('inspection_vin_no')->nullable();
            $table->string('inspection_vehicle_model')->nullable();
            $table->string('inspection_vehicle_color')->nullable();
            $table->string('inspection_vehicle_year')->nullable();
            $table->string('inspection_plate_no')->nullable();
            $table->string('inspection_contact')->nullable();
            $table->string('inspection_ar_no')->nullable();
            $table->string('inspection_country')->nullable();
            $table->string('inspection_state')->nullable();
            $table->string('inspection_city')->nullable();
            $table->string('inspection_district')->nullable();
            $table->string('inspection_control_technique')->nullable();
            $table->string('inspection_date_of_inspection')->nullable();
            $table->string('inspection_date_of_expiration')->nullable();


            $table->string('parking_owner_mobile_no')->nullable();
            $table->string('parking_address')->nullable();
            $table->string('parking_vehicle_color')->nullable();
            $table->string('parking_vehicle_model')->nullable();
            $table->string('parking_plate_no')->nullable();
            $table->string('parking_mobile')->nullable();
            $table->string('parking_country')->nullable();
            $table->string('parking_state')->nullable();
            $table->string('parking_city')->nullable();
            $table->string('parking_district')->nullable();
            $table->string('parking_p_place_of_registration')->nullable();
            $table->string('parking_p_registration_officer')->nullable();
            $table->string('parking_p_date_of_payment')->nullable();
            $table->string('parking_expiration_date')->nullable();
            $table->string('parking_parking_plan')->nullable();
            $table->string('parking_status')->nullable();
            $table->string('parking_date_of_inspection')->nullable();
            $table->string('parking_date_of_expiration')->nullable();
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
            $table->dropColumn('registration_address');
            $table->dropColumn('registration_chassis_no');
            $table->dropColumn('registration_vin_no');
            $table->dropColumn('registration_vehicle_model');
            $table->dropColumn('registration_vehicle_color');
            $table->dropColumn('registration_vehicle_year');
            $table->dropColumn('registration_plate_no');
            $table->dropColumn('registration_country');
            $table->dropColumn('registration_state');
            $table->dropColumn('registration_city');
            $table->dropColumn('registration_district');
            $table->dropColumn('registration_emergency_contact_no');
            $table->dropColumn('registration_ar_no');
            $table->dropColumn('registration_pcn_no');


            $table->dropColumn('inspection_address');
            $table->dropColumn('inspection_chassis_no');
            $table->dropColumn('inspection_vin_no');
            $table->dropColumn('inspection_vehicle_model');
            $table->dropColumn('inspection_vehicle_color');
            $table->dropColumn('inspection_vehicle_year');
            $table->dropColumn('inspection_plate_no');
            $table->dropColumn('inspection_contact');
            $table->dropColumn('inspection_ar_no');
            $table->dropColumn('inspection_country');
            $table->dropColumn('inspection_state');
            $table->dropColumn('inspection_city');
            $table->dropColumn('inspection_district');
            $table->dropColumn('inspection_control_technique');
            $table->dropColumn('inspection_date_of_inspection');
            $table->dropColumn('inspection_date_of_expiration');


            $table->dropColumn('parking_owner_mobile_no');
            $table->dropColumn('parking_address');
            $table->dropColumn('parking_vehicle_color');
            $table->dropColumn('parking_vehicle_model');
            $table->dropColumn('parking_plate_no');
            $table->dropColumn('parking_mobile');
            $table->dropColumn('parking_country');
            $table->dropColumn('parking_state');
            $table->dropColumn('parking_city');
            $table->dropColumn('parking_district');
            $table->dropColumn('parking_p_place_of_registration');
            $table->dropColumn('parking_p_registration_officer');
            $table->dropColumn('parking_p_date_of_payment');
            $table->dropColumn('parking_expiration_date');
            $table->dropColumn('parking_parking_plan');
            $table->dropColumn('parking_status');
            $table->dropColumn('parking_date_of_inspection');
            $table->dropColumn('parking_date_of_expiration');
        });
    }
}
