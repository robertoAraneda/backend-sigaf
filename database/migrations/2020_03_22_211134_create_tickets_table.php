<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tickets', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('course_registered_user_id');

      $table->unsignedBigInteger('type_ticket_id'); //entrante-saliente

      $table->unsignedBigInteger('status_ticket_id'); //Abierto-Cerrado

      $table->unsignedBigInteger('priority_ticket_id'); //alta-media-baja

      $table->unsignedBigInteger('source_ticket_id'); //teléfono-email

      $table->unsignedBigInteger('motive_ticket_id'); //bienvenida-problema

      $table->unsignedBigInteger('user_create_id');
      $table->unsignedBigInteger('user_assigned_id');
      $table->timestamp('closing_date')->nullable();
      $table->timestamps();

      $table->foreign('course_registered_user_id')->references('id')->on('course_registered_users');
      $table->foreign('type_ticket_id')->references('id')->on('type_tickets');
      $table->foreign('source_ticket_id')->references('id')->on('source_tickets');
      $table->foreign('status_ticket_id')->references('id')->on('status_tickets');
      $table->foreign('priority_ticket_id')->references('id')->on('priority_tickets');
      $table->foreign('motive_ticket_id')->references('id')->on('motive_tickets');
      $table->foreign('user_create_id')->references('id')->on('users');
      $table->foreign('user_assigned_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tickets');
  }
}
