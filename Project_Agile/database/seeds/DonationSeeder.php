<?php

use App\Donation;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
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
            [2, "Ricardo", "van", "Bergen", "Ik vind het koffieschenken erg leuk gedaan!!", 140, "Ricardo@gmail.com", '0630215689', "2020-05-03 16:32:18", 0],
            [4, "Eva", "van der", "Bleken", "Hallo, ik heb 2 koffiemokken die ik kan brengen.", 2, "eva_bleken@hotmail.com", '0656894712', "2020-05-03 10:56:02", 0],
            [4, "Tom", null, "Lagerweij", "Ik heb wat mokken over die juillie mogen gebruiken", 4, "TomLagerweij@outlook.com", '0612457869', "2020-05-06 15:00:32", 0],
            [6, "Rens", null, "Aspers", "Er liggen nog wat vishengels in mijn schuur", 4, "Rens@outlook.nl", '0613467958', "2020-05-06 20:40:32", 0]
        ];

        $this->seed(Donation::class, $data);
    }
}
