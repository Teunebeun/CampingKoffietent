<?php

use App\DonationTarget;
use Illuminate\Database\Seeder;

class DonationTargetSeeder extends Seeder
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
            [null, "Euro", 0, 0, "Algemene Donatie", "Wil je een bedrag doneren aan camping Koffietent? Elk kleine beetje helpt!", new DateTime(), 0],
            [null, "Euro", 200.00, 154.00, "Spaarpot voor koffieapparaat", "We hebben €200,- nodig om een nieuwe koffieapparaat te kopen.", new DateTime(), 0],
            [2, "Euro", 50, 12, "Geld nodig", "Tijdens de inzamelingactie willen we eten aanbieden voor de mensen die mee helpen.", new DateTime(), 0],
            [3, "Koffiemokken", 8, 0, "8 stoelen tekort!", "We hebben 8 stoelen nodig voor de opkomende tekenactiviteit!!", new DateTime(), 0],
            [3, "Papiervellen", 50, 0, "Papier hier!!", "We hebben nog wat papiervellen nodig voor de opkomende activiteit!!", new DateTime(), 0],
            [7, "Vishengels", 10, 0, "Vishengels nodig!!", "Helaas hebben wij niet genoeg vishengels over om mee te vissen.", new DateTime(), 0],
            [7, "Euro", 10, 2, "Aas om vissen te vangen", "Om vissen te vangen hebben we helaas ook aas nodig, hier hebben we een spaarpotje voor gemaakt.", new DateTime(), 0]
        ];

        $this->seed(DonationTarget::class, $data);
    }
}
