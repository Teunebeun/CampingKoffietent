<?php

use App\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
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
            ["Koffie drinken", 1, "Kom lekker koffie drinken!! We zijn open op vasis van vrijwilligheid", "/img/activityDisplayPicture/koffie.jpg"],
            ["Tekenen", 4, "Wij vertrekken dit tekenfestival vanuit de gedachte dat kunst verbindt. Het is belangrijk dat zoveel mogelijk mensen met kunst in aanraking komen. Met dit laagdrempelige kunstevenement hopen we ook niet kunstminnend publiek te enthousiasmeren voor kunst.", "/img/activityDisplayPicture/drawing.jpg"],
            ["De plastic soep", 2, "Onze jongste campingbazen Sophie, Indra en Manou houden zondag 23 maart de ‘Grote Plastic Inzamelactie’. Geef je op als deelnemer (vanaf 8 jaar) en loop mee langs de Bossche wateren om het (plastic) zwerfafval op te ruimen. De 2 deelnemers die het meeste afval inzamelen winnen een mooie prijs. En die houden we nog even geheim.","/img/activityDisplayPicture/plastic-soep.jpg"],
            ["Vissen", 1,"Wij vertrekken dit visfestival vanuit de gedachte dat vissen verbindt.", "/img/activityDisplayPicture/fishing.jpg"],
            ["Kookwedstrijd", 2, "De Kookwedstrijd omvat het met elkaar bereiden van ons 4-gangen Top Chefs menu. Tevens is er een culinaire quiz en een competitief element waarbij de verschillende teams worden beoordeeld aan de hand van criteria als samenwerking, creativiteit, presentatie en hygiëne. Aansluitend aan het diner vindt er een cook-off plaats tussen de twee best scorende teams en ontvangt het winnende team de Kookfabriek bokaal. De kookwedstrijd duurt een half uur langer dan het Top Chefs arrangement.", "/img/singularItem/activiteit.png"],
            ["Eetwedstrijd", 3, "Ben je persoonlijk geïnteresseerd in eetwedstrijden, en zou je het wel eens willen proberen? Dan kun je hier beginnen!!." , "/img/activityDisplayPicture/fishing.jpg"]
        ];

        $this->seed(Activity::class, $data);
    }
}
