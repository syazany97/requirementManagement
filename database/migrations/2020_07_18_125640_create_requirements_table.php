<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('module_id')
                ->constrained();
            $table->text('description');
            $table->unsignedBigInteger('requirement_priority_id');
            $table->foreign('requirement_priority_id')
                ->references('id')
                ->on('requirement_priorities');
            $table->unsignedBigInteger('requirement_status_id')
                ->nullable();
            $table->foreign('requirement_status_id')
                ->references('id')
                ->on('requirement_statuses');
            $table->unsignedBigInteger('assigned_id')
                ->nullable();
            $table->unsignedBigInteger('creator_id')
                ->nullable();
            $table->string('numbering')
                ->nullable();
            $table->foreign('assigned_id')
                ->references('id')
                ->on('users');
            $table->foreign('creator_id')
                ->references('id')
                ->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirements');
    }
}
