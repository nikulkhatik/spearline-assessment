<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('company_id')->index('idx_job_company_id');
            $table->integer('test_type_id')->index('idx_job_test_type_id');
            $table->string('name', 255);
            $table->dateTime('start_time')->default('0000-00-00 00:00:00')->index('idx_job_start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job');
    }
}
