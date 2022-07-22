<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobProcessingFailoverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_processing_failover', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('test_type_id')->index('idx_job_processing_failover_test_type_id');
            $table->integer('job_id')->index('idx_job_processing_failover_job_id');
            $table->integer('number_id')->index('idx_job_processing_failover_number_id');
            $table->dateTime('call_start_time')->default('0000-00-00 00:00:00')->index('idx_job_processing_failover_call_start_time');
            $table->dateTime('call_connect_time')->default('0000-00-00 00:00:00');
            $table->dateTime('call_end_time')->default('0000-00-00 00:00:00');
            $table->integer('call_description_id')->nullable()->index('idx_job_processing_failover_call_description_id');
            $table->dateTime('created_on')->default('0000-00-00 00:00:00');
            $table->dateTime('updated_on')->default('0000-00-00 00:00:00')->index('idx_job_processing_failover_updated_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_processing_failover');
    }
}
