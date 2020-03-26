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
      $table->string('last_access_registered_moodle', 255)->nullable();
      $table->timestamps();
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
