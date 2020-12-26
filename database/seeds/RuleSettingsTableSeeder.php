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
        $rs->activated_r1 = true;
        $rs->activated_r2 = true;
        $rs->activated_r3 = true;
        $rs->activated_r4 = true;
        $rs->activated_r5 = true;
        $rs->activated_r6 = true;
        $rs->breathing_rate = 30;
        $rs->days_to_evaluate = 10;
        $rs->oxigen_saturation = 92;
        $rs->oxigen_saturation_down_percentage = 3;
        $rs->save(); 
    }
}
