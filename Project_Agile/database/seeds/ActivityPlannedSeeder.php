<?php

use App\ActivityPlanned;
use Illuminate\Database\Seeder;

class ActivityPlannedSeeder extends Seeder
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
            ["Koffie drinken", "Kom lekker koffie drinken!! We zijn open op basis van vrijwilligheid.", "/img/activityDisplayPicture/koffie.jpg", 1, "2020-05-07 10:00:00", "2020-05-07 13:00:00"],
            ["De plastic soep", "We houden weer de Grote Plastic Inzamelactie. Geef je op als deelnemer [vanaf 8 jaar] en loop mee langs de Bossche wateren om het [plastic] zwerfafval op te ruimen. De 2 deelnemers die het meeste afval inzamelen winnen een mooie prijs. En die houden we nog even geheim.","/img/activityDisplayPicture/plastic-soep.jpg", 3, "2020-05-07 13:00:00", "2020-05-07 18:00:00"],
            ["De plastic soep", "Onze jongste campingbazen Sophie, Indra en Manou houden 12 april de ‘Grote Plastic Inzamelactie’. Geef je op als deelnemer [vanaf 8 jaar] en loop mee langs de Bossche wateren om het [plastic] zwerfafval op te ruimen. De 2 deelnemers die het meeste afval inzamelen winnen een mooie prijs. En die houden we nog even geheim.","/img/activityDisplayPicture/plastic-soep.jpg", 3, "2020-04-12 10:00:00", "2020-04-12 18:00:00"],
            ["Tekenen", "Wij vertrekken dit tekenfestival vanuit de gedachte dat kunst verbindt. Het is belangrijk dat zoveel mogelijk mensen met kunst in aanraking komen. Met dit laagdrempelige kunstevenement hopen we ook niet kunstminnend publiek te enthousiasmeren voor kunst.", "/img/activityDisplayPicture/drawing.jpg", 2, "2020-05-10 08:00:00", "2020-05-10 18:00:00"],
            ["Tekenen", "Houd jij ook van kunst en vindt jij dat dit ons verbindt? Kom langs! Bij de spectaculaire teken kunsten van onze campinggasten", "/img/activityDisplayPicture/drawing.jpg", 2, "2020-04-26 08:00:00", "2020-04-26 18:00:00"],
            ["Kookwedstrijd 2020", "Zoals van ouds gaan we weer eens lekker koken! De gene met het beste gerecht wint!", "/img/activityDisplayPicture/koken.jpeg", 5, "2020-05-11 08:00:00", "2020-05-11 18:00:00"],
            ["Vissen met de campingbazen", "Dit jaar gaan alle campingbazen vissen, heb jij ook zin om mee te doen? Of wil je even langskomen? Kijk naar onze openingstijden", "/img/activityDisplayPicture/fishing.jpg", 5, "2020-05-26 13:00:00", "2020-05-11 18:00:00"]
        ];

        $this->seed(ActivityPlanned::class, $data);
    }
}
