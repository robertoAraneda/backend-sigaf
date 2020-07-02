<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRegisteredUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('course_registered_users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('course_id');
      $table->unsignedBigInteger('registered_user_id');
      $table->unsignedBigInteger('profile_id')->default(1);
      $table->unsignedBigInteger('classroom_id')->default(1);
      $table->unsignedBigInteger('final_status_id')->default(1);
      $table->unsignedInteger('final_qualification')->default(1);
      $table->unsignedInteger('final_qualification_moodle')->nullable();
      $table->string('last_access_registered_moodle', 25);
      $table->timestamps();

      $table->foreign('course_id')->references('id')->on('courses');
      $table->foreign('registered_user_id')->references('id')->on('registered_users');
      $table->foreign('profile_id')->references('id')->on('profiles');
      $table->foreign('classroom_id')->references('id')->on('classrooms');
      $table->foreign('final_status_id')->references('id')->on('final_statuses');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('course_registered_users');
  }
}
