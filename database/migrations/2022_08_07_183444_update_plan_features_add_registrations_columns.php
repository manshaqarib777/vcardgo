<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlanFeaturesAddRegistrationsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_features', function (Blueprint $table) {
            $table->boolean('registration_custom_idea')->default(false);
            $table->boolean('inspection_custom_idea')->default(false);
            $table->boolean('inspection_custom_idea_new')->default(false);
            $table->boolean('custom_id')->default(false);
            $table->boolean('parking_custom_idea')->default(false);
            $table->boolean('privacy_policy')->default(false);
            $table->boolean('term_condition')->default(false);
            $table->boolean('business_hours')->default(false);
            $table->boolean('qr_code')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_features', function (Blueprint $table) {
            $table->dropColumn('registration_custom_idea');
            $table->dropColumn('inspection_custom_idea');
            $table->dropColumn('inspection_custom_idea_new');
            $table->dropColumn('custom_id');
            $table->dropColumn('parking_custom_idea');
            $table->dropColumn('privacy_policy');
            $table->dropColumn('term_condition');
            $table->dropColumn('business_hours');
            $table->dropColumn('qr_code');
        });
    }
}
