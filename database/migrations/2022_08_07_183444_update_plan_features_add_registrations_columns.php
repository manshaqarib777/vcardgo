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
            $table->boolean('parking_custom_idea')->default(false);
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
            $table->dropColumn('parking_custom_idea');
        });
    }
}
