<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->decimal('year', 4, 0);
            $table->decimal('month', 2, 0);
            $table->decimal('total_leave_days', 2, 0)->nullable();
            $table->decimal('total_leave_fines', 10, 2)->nullable();
            $table->decimal('total_overtimes', 5, 1)->nullable();
            $table->decimal('total_overtime_fees', 10, 2)->nullable();
            $table->decimal('total_working_hours', 5, 1)->nullable();
            $table->decimal('salary', 10, 2);
            $table->string('file', 255);
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
        Schema::dropIfExists('final_salaries');
    }
}
