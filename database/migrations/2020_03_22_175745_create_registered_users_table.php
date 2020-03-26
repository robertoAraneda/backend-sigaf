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
      $table->string('rut', 15)->nullable();
      $table->string('name', 255)->nullable();
      $table->string('last_name', 255)->nullable();
      $table->string('mother_last_name', 255)->nullable();
      $table->string('email', 255)->nullable();
      $table->string('phone', 20)->nullable();
      $table->string('mobile', 20)->nullable();
      $table->string('address', 255)->nullable();
      $table->string('city', 255)->nullable();
      $table->string('region', 255)->nullable();
      $table->string('rbd_school', 255)->nullable();
      $table->string('name_school', 255)->nullable();
      $table->string('city_school', 255)->nullable();
      $table->string('region_school', 255)->nullable();
      $table->string('phone_school', 20)->nullable();
      $table->unsignedBigInteger('id_registered_moodle')->nullable();
      $table->string('rut_registered_moodle', 15)->nullable();
      $table->string('name_registered_moodle', 255)->nullable();
      $table->string('email_registered_moodle', 255)->nullable();
      $table->unsignedInteger('status_moodle')->default(1);
      $table->unsignedBigInteger('user_create_id')->default(1);
      $table->unsignedBigInteger('user_update_id')->default(1);
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
    Schema::dropIfExists('registered_users');
  }
}
