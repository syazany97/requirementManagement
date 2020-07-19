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
            $table->foreignId('requirement_priority_id')
                ->constrained();
            $table->foreignId('requirement_status_id')
                ->constrained();
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
