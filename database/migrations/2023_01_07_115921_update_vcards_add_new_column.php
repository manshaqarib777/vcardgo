<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVcardsAddNewColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->text('comercial')->nullable();
            $table->text('non_comercial')->nullable();
            $table->text('dd')->nullable();
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
            $table->dropColumn('comercial');
            $table->dropColumn('non_comercial');
            $table->dropColumn('dd');
        });
    }
}
