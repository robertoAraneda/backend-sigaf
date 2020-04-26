<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ticket_details', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('ticket_id');
      $table->unsignedBigInteger('user_created_id');
      $table->unsignedBigInteger('status_detail_ticket_id');
      $table->string('comment');
      $table->timestamps();

      $table->foreign('ticket_id')->references('id')->on('tickets');
      $table->foreign('user_created_id')->references('id')->on('users');
      $table->foreign('status_detail_ticket_id')->references('id')->on('status_detail_tickets');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('ticket_details');
  }
}
