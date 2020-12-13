<?php

use Illuminate\Database\Seeder;
use App\RuleSettings;

class RuleSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rs = new RuleSettings;
        $rs->activated = true;
        $rs->breathing_rate = 30;
        $rs->days_to_evaluate = 10;
        $rs->oxigen_saturation = 92;
        $rs->oxigen_saturation_down_percentage = 3;
        $rs->save(); 
    }
}
