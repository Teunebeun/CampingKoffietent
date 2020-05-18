<?php

use App\Campingbaas;
use Illuminate\Database\Seeder;

class CampingbaasSeeder extends Seeder
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
            ["Imke", "van", "Dillen", "/img/campingbaas/imke.jpg", "/img/campingbaas/imke.jpg", "De dagelijkse organisatie is gemandeerd aan directeur en oprichter Imke van Dillen. De functie van Imke van Dillen is een bundeling van rollen als leegstandsbeheerder, curator, buurtverbinder en ondersteunend producent.", "ffffff", "calibri", 12, 1, "imke@gmail.com", "1234567890"],
            ["Olga", null, null, "/img/campingbaas/olga.jpg", "/img/campingbaas/olga.jpg", "organisatie opstart/initiatieven", "000000", "Arial", 20, 0, "olga@gmail.com", "1234567890"],
            ["Anna", null, null, "/img/campingbaas/anna.jpg", "/img/campingbaas/anna.jpg", "ontwerp + regie verbouwing", "ff0000", "verdana", 9, 0, "anna@gmail.com", "1234567890"],
            ["Jeroen", null, null, "/img/campingbaas/jeroen.jpg", "/img/campingbaas/jeroen.jpg", "concept & huisstijl", "00ff00", "times new roman", 13, 0, "jeroen@gmail.com", "1234567890"],
            ["Marieke", null, null, "/img/campingbaas/marieke.jpg", "/img/campingbaas/marieke.jpg", "Eerste hulp & deelboot", "0000ff", "Arial", 11, 0, "marieke@gmail.com", "1234567890"],
            ["Peter", null, null, "/img/campingbaas/peter.jpeg", "/img/campingbaas/peter.jpeg", "coördinatie & schenkt koffie op vrij", "0f00f0", "Arial", 14, 1, "peter@gmail.com", "1234567890"]
        ];

        $this->seed(Campingbaas::class, $data);
    }
}
