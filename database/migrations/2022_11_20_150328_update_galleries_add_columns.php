<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGalleriesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('gallery_name')->nullable();
            $table->string('description')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('ticket_fine')->nullable();
            $table->string('ticket_status')->nullable();
            $table->string('date_before')->nullable();
            $table->string('fine')->nullable();
            $table->string('agent_name')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('date');
            $table->dropColumn('time');
            $table->dropColumn('ticket_fine');
            $table->dropColumn('ticket_status');
            $table->dropColumn('date_before');
            $table->dropColumn('fine');
            $table->dropColumn('agent_name');
        });
    }
}
