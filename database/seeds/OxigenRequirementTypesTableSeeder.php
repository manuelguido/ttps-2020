<?php

use Illuminate\Database\Seeder;
use App\OxigenRequirementType;

class OxigenRequirementTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OxigenRequirementType::createOxigenRequirementType(OxigenRequirementType::CANNULA);
        OxigenRequirementType::createOxigenRequirementType(OxigenRequirementType::MASK);
    }
}
