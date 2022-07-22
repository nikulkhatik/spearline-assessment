<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToJobProcessingEchoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_processing_echo', function (Blueprint $table) {
            $table->foreign(['call_description_id'], 'job_processing_echo_ibfk_4')->references(['id'])->on('call_description')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['number_id'], 'job_processing_echo_ibfk_3')->references(['id'])->on('number')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['job_id'], 'job_processing_echo_ibfk_2')->references(['id'])->on('job')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['test_type_id'], 'job_processing_echo_ibfk_1')->references(['id'])->on('test_type')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_processing_echo', function (Blueprint $table) {
            $table->dropForeign('job_processing_echo_ibfk_4');
            $table->dropForeign('job_processing_echo_ibfk_3');
            $table->dropForeign('job_processing_echo_ibfk_2');
            $table->dropForeign('job_processing_echo_ibfk_1');
        });
    }
}
