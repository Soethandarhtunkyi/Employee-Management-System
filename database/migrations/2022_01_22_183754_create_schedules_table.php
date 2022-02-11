<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 255);
            $table->string('file', 255);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(0)->comment('0 for not started, 1 for progress, 2 for finished');
            $table->foreignId('project_id')->references('id')->on('projects');
            $table->foreignId('assignor_id')->references('id')->on('employees');
            $table->foreignId('assignee_id')->references('id')->on('employees');
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
        Schema::dropIfExists('schedules');
    }
}
