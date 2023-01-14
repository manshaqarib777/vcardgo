<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateScheduleAppointmentsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_appointments', function (Blueprint $table) {
            $table->string('reason')->nullable();
            $table->string('message')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_appointments', function (Blueprint $table) {
            $table->dropColumn('reason');
            $table->dropColumn('message');
        });
    }
}
