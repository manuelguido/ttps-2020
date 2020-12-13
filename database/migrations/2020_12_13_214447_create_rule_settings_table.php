<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuleSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_settings', function (Blueprint $table) {
            $table->bigIncrements('rule_setting_id');
            $table->boolean('activated');
            $table->integer('breathing_rate');
            $table->integer('days_to_evaluate');
            $table->integer('oxigen_saturation');
            $table->integer('oxigen_saturation_down_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_settings');
    }
}
