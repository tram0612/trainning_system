<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCourseSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_subject', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('subject_id');
            $table->boolean('status')->nullable()->default(0);//0:start 1:finish
            $table->date('started_at')->nullable();
            $table->smallInteger('days')->nullable();
            $table->smallInteger('position')->nullable();
            $table->timestamps();
            $table->softDeletes(); // add
            $table->foreign('course_id')->references('id')->on('course');
            $table->foreign('subject_id')->references('id')->on('subject');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_subject');
    }
}
