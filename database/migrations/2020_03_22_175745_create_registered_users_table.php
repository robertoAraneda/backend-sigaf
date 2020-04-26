<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisteredUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('registered_users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('rut', 12)->nullable();
      $table->string('name', 25)->nullable();
      $table->string('last_name', 25)->nullable();
      $table->string('mother_last_name', 25)->nullable();
      $table->string('email', 25)->nullable();
      $table->string('phone', 12)->nullable();
      $table->string('mobile', 12)->nullable();
      $table->string('address', 25)->nullable();
      $table->string('city', 25)->nullable();
      $table->string('region', 25)->nullable();
      $table->string('rbd_school', 7)->nullable();
      $table->string('name_school', 50)->nullable();
      $table->string('city_school', 25)->nullable();
      $table->string('region_school', 25)->nullable();
      $table->string('phone_school', 12)->nullable();
      $table->unsignedBigInteger('id_registered_moodle')->nullable();
      $table->string('rut_registered_moodle', 12)->nullable();
      $table->string('name_registered_moodle', 50)->nullable();
      $table->string('email_registered_moodle', 25)->nullable();
      $table->unsignedInteger('status_moodle')->default(1);
      $table->unsignedBigInteger('user_create_id')->default(1);
      $table->unsignedBigInteger('user_update_id')->default(1);
      $table->timestamps();

      $table->foreign('user_create_id')->references('id')->on('users');
      $table->foreign('user_update_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('registered_users');
  }
}
