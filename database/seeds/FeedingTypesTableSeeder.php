<?php

use Illuminate\Database\Seeder;
use App\FeedingType;

class FeedingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeedingType::createFeedingType(FeedingType::ORAL);
        FeedingType::createFeedingType(FeedingType::ENTERAL);
        FeedingType::createFeedingType(FeedingType::PARENTERAL);
    }
}
