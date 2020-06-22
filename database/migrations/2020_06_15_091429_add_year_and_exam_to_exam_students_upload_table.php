<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearAndExamToExamStudentsUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_students_upload', function (Blueprint $table) {
            $table->integer('year');
            $table->string('exam');
            $table->string('nsid_status');
            $table->string('db_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_students_upload', function (Blueprint $table) {
            //
        });
    }
}
