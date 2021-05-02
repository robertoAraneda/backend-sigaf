<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketReportExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_report_excels', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->string('rut_student');
            $table->string('name_student');
            $table->string('lastname_student');
            $table->string('classroom_student');
            $table->string('source_ticket');
            $table->string('type_ticket');
            $table->string('motive_ticket');
            $table->string('last_access_moodle');
            $table->string('priority_ticket');
            $table->string('created_user_ticket');
            $table->string('assigned_user_ticket');
            $table->string('status_ticket');
            $table->string('created_at_ticket');
            $table->string('clossed_at_ticket')->nullable();
            $table->string('age_ticket');
            $table->string('status_ticket_detail')->nullable();
            $table->text('comment_ticket_detail')->nullable();
            $table->string('created_at_ticket_detail')->nullable();
            $table->string('created_user_ticket_detail')->nullable();
            $table->text('historical_ticket_detail')->nullable();
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
        Schema::dropIfExists('ticket_report_excels');
    }
}
