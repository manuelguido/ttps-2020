<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactInformationToPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('email')->nullable()->default(NULL);
            $table->string('contact_name')->nullable()->default(NULL);
            $table->string('contact_lastname')->nullable()->default(NULL);
            $table->bigInteger('contact_phone')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('email');
            $table->string('contact_name');
            $table->string('contact_lastname');
            $table->bigInteger('contact_phone');
        });
    }
}
