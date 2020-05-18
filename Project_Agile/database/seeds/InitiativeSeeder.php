<?php

use App\Initiative;
use Illuminate\Database\Seeder;

class InitiativeSeeder extends Seeder
{
    use SeedEncrypted;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, "Varen", "Ik denk dat het leuk zou zijn om met iedereen van de camping een middagje te varen", "2020-05-05 14:23:09", 0],
            [2, "Picknick!!!", "Met dit mooie weer zou het toch ontzettend leuk zijn om met mensen te gaan picknicken!", new DateTime(), 0],
            [3, "BBQ", "Ik heb een grote barbecue, deze zouden we op de straat kunnen zetten en dan aan iedereen die wil een hamburger geven.", "2020-05-05 18:36:49", 0]
        ];

        $this->seed(Initiative::class, $data);
    }
}
