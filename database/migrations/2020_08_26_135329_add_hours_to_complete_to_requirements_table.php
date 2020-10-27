<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHoursToCompleteToRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->bigInteger('hours_to_complete')
                ->after('description')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn(['hours_to_complete']);
        });
    }
}
