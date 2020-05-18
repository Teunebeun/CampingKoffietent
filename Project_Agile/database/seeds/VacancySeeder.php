<?php

use App\Vacancy;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
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
            ["Tekenspullen organiseren!!", "Wij hebben hulp nodig, heb jij een passie voor tekene en abstracte kunst, schrijf je aub in!!", "2020-05-10 10:00:00", "2020-05-10 12:00:00", "/img/activityDisplayPicture/drawing.jpg", 0, 4, 2, 0, 1],
            ["Kom kletsen", "De koffietent is soms wat leegjes, woon je in de buurt en heb je tijd over kom lekker kletsen, deel je verhaal", "2020-04-10 19:00:00", "2020-04-10 20:00:00", "/img/vacancy/act3.jpg", 0, null, 1, 0, 1],
            ["Verzorg de tuin", "Het gras ziet er niet meer zoals van ouds uit, om dit op te lossen zijn wij opzoek naar iemand die verstand heeft van groen en ons wil helpen.", "2020-05-08 19:00:00", "2020-05-10 20:00:00", "/img/vacancy/act4.jpg", 0, null, 1, 0, 1],
            ["Kom schoonmaken", "Op 10 mei houden wij een grootte schoonmaak actie en hiervoor zijn wij opzoek naar echte schoonmaak freaks!", "2020-05-10 19:00:00", "2020-05-10 20:00:00", "/img/vacancy/act5.jpg", 0, null, 1, 0, 1],
            ["Help ouderen", "Als u een bewoner uit het verzorginshuis meeneemt, dan krijgen juillie allebij een lekker kopje koffie!", "2020-04-12 19:00:00", "2020-04-12 20:00:00", "/img/vacancy/act6.jpg", 0, null, 1, 0, 1]
        ];

        $this->seed(Vacancy::class, $data);
    }
}
