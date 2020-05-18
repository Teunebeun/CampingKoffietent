<?php

use App\Sponsor;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
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
            ["Coffeelab", "/img/sponsor/sponsor7.png", "Wij zijn gek op koffie. Dat kan haast ook niet anders, het is zo’n mooi en veelzijdig product! Met liefde zetten we een snelle koffie voor je de trein haalt, of geniet je binnen van een subtiele filterkoffie of espresso voor de cafeïne-kick. We willen er zijn voor zowel de treinreiziger als voor de Eindhovenaren en Bosschenaren zelf. Je schuift bij ons gezellig aan bij een van de grote tafels, maar er is ook ruimte om wat meer privé te zitten als je bijvoorbeeld nog even moet werken.", "https://www.coffeelab.nl/"],
            ["Stichting brugwachterhuisjes", "/img/sponsor/sponsor6.png", "De Stichting Brugwachtershuisjes zet zich in om de oude huisjes een nieuwe bestemming te geven. De huisjes staan in stedelijke en landelijke omgevingen. De stichting heeft de overtuiging dat een leuke beleving van deze huisjes het beste verzekerd  wordt door deze huisjes een nieuwe functie te geven.", "http://brugwachtershuisjes.nl/"],
            ["Prins Bernhard cultuurfonds", "/img/sponsor/sponsor.jpg", "Buurtcultuurfonds BrabantWonen geeft aan cultuurprojecten die bijdragen aan de ''kunst van het samenleven'' binnen de wijken in ’s-Hertogenbosch waar Woningbouwvereniging BrabantWonen woningbezit heeft. Aanvragen worden behandeld door het Prins Bernhard Cultuurfonds.", "https://www.cultuurfonds.nl/"],
            ["Den Bosch", "/img/sponsor/sponsor2.jpg", "De gemeente ''s-Hertogenbosch is de gemeente waarin de Camping Koffietent staat. De Camping Koffietent staat in de buurt van het centrum van 's-Hertogenbosch gelegen aan de Dieze.", "https://www.s-hertogenbosch.nl/"],
            ["Anarchi", "/img/sponsor/sponsor3.jpg", "Annarchi is een bedrijf gericht op architectuur, interieur en design. Annarchi heeft de Camping Koffietent geholpen met de inrichting van de plek waar de Camping Koffietent staat. De buitenkant van het gebouw en de binnenkant van het gebouw zijn ontworpen en ingericht door Annarchi.", "https://www.anarchi.cc/"],
            ["Brabant wonen", "/img/sponsor/sponsor5.png", "BrabantWonen heeft een Buurtfonds. Vanuit dit fonds kunnen projecten gestart worden. Deze projecten kunnen de contacten tussen de buurtbewoners vernieuwen of versterken. Door samen een project te starten, ontstaan er vaak mooie ontmoetingen tussen buurtbewoners.", "https://www.brabantwonen.nl/"],
            ["Weeshuisjes", "/img/sponsor/sponsor4.png", "Weeshuisjes - oude ruimtes, nieuwe adem is een organisatie die leegstaand kleinschalig erfgoed een nieuw leven geven. De oude of lege plek wordt her-gewaardeerd, omdat het nieuwe betekenis geeft. De Camping Koffietent is een van de meerdere projecten van Weeshuisjes. ", "https://www.weeshuisjes.nl/"]
        ];

        $this->seed(Sponsor::class, $data);
    }
}
