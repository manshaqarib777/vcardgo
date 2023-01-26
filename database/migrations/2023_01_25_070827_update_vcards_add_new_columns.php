<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardsAddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->text('category_a_checkbox')->nullable();
            $table->text('category_b_checkbox')->nullable();
            $table->text('category_c_checkbox')->nullable();
            $table->text('category_d_checkbox')->nullable();
            $table->text('category_e_checkbox')->nullable();
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
            $table->dropColumn('category_a_checkbox');
            $table->dropColumn('category_b_checkbox');
            $table->dropColumn('category_c_checkbox');
            $table->dropColumn('category_d_checkbox');
            $table->dropColumn('category_e_checkbox');
        });
    }
}
