<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardsAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->text('alternative_email')->nullable();
            $table->text('alternative_phone')->nullable();
            $table->text('alternative_region_code')->nullable();
            $table->text('issue_date')->nullable();
            $table->text('expire_date')->nullable();
            $table->text('hair_color')->nullable();
            $table->text('made_by_url')->nullable();
            $table->text('eye_color')->nullable();
            $table->text('sex')->nullable();
            $table->text('type')->nullable();
            $table->text('height')->nullable();
            $table->text('weight')->nullable();
            $table->text('rstr')->nullable();
            $table->text('address')->nullable();
            $table->text('category')->nullable();
            $table->text('barcode_url')->nullable();
            $table->text('qrcode_url')->nullable();
            $table->text('category_a_text')->nullable();
            $table->text('category_b_text')->nullable();
            $table->text('category_c_text')->nullable();
            $table->text('category_d_text')->nullable();
            $table->text('category_e_text')->nullable();
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
            $table->dropColumn('alternative_email');
            $table->dropColumn('alternative_phone');
            $table->dropColumn('alternative_region_code');
            $table->dropColumn('issue_date');
            $table->dropColumn('expire_date');
            $table->dropColumn('hair_color');
            $table->dropColumn('made_by_url');
            $table->dropColumn('eye_color');
            $table->dropColumn('sex');
            $table->dropColumn('registration_city');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('rstr');
            $table->dropColumn('address');
            $table->dropColumn('inspection_address');
            $table->dropColumn('inspection_chassis_no');
            $table->dropColumn('inspection_vin_no');
            $table->dropColumn('category_a_text');
            $table->dropColumn('category_b_text');
            $table->dropColumn('category_c_text');
            $table->dropColumn('category_d_text');
            $table->dropColumn('category_e_text');
        });
    }
}
