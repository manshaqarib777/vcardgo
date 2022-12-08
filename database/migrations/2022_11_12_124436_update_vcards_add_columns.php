<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->text('inspection_address_new')->nullable();
            $table->text('inspection_chassis_no_new')->nullable();
            $table->text('inspection_vin_no_new')->nullable();
            $table->text('inspection_vehicle_model_new')->nullable();
            $table->text('inspection_vehicle_color_new')->nullable();
            $table->text('inspection_vehicle_year_new')->nullable();
            $table->text('inspection_plate_no_new')->nullable();
            $table->text('inspection_contact_new')->nullable();
            $table->text('inspection_ar_no_new')->nullable();
            $table->text('inspection_country_new')->nullable();
            $table->text('inspection_state_new')->nullable();
            $table->text('inspection_city_new')->nullable();
            $table->text('inspection_district_new')->nullable();
            $table->text('inspection_control_technique_new')->nullable();
            $table->text('inspection_date_of_inspection_new')->nullable();
            $table->text('inspection_date_of_expiration_new')->nullable();
            $table->text('vcard_unique_number')->nullable();
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
            $table->dropColumn('inspection_address_new');
            $table->dropColumn('inspection_chassis_no_new');
            $table->dropColumn('inspection_vin_no_new');
            $table->dropColumn('inspection_vehicle_model_new');
            $table->dropColumn('inspection_vehicle_color_new');
            $table->dropColumn('inspection_vehicle_year_new');
            $table->dropColumn('inspection_plate_no_new');
            $table->dropColumn('inspection_contact_new');
            $table->dropColumn('inspection_ar_no_new');
            $table->dropColumn('inspection_country_new');
            $table->dropColumn('inspection_state_new');
            $table->dropColumn('inspection_city_new');
            $table->dropColumn('inspection_district_new');
            $table->dropColumn('inspection_control_technique_new');
            $table->dropColumn('inspection_date_of_inspection_new');
            $table->dropColumn('inspection_date_of_expiration_new');
            $table->dropColumn('vcard_unique_number');
        });
    }
}
