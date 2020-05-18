<?php

use App\SingularItems;
use Illuminate\Database\Seeder;

class SingularItemsSeeder extends Seeder
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
            ["/img/singularItem/logo.png",
            "Camping Koffietent",
            "​HALLO DEN BOSCH!, CAMPING HIER, ​HET KLEINSTE KOFFIETENTJE MET EEN GROOTS IDEAAL: EEN ONTMOETINGSPLEK VOOR DE STAD, MET UITZICHT OP HET WATER, DE WOLKEN EN HET GROEN VOOR HET GEVOEL VAN VAKANTIE OP EEN DOORDEWEEKSE DAG. VOOR EEN PRAATJE, VOOR EEN SPONTAAN INITIATIEF EN VOOR KOFFIE!",
            "/img/singularItem/bigImg.jpg",
            "10:00-17:00",
            "10:00-12:00 & 13:00-16:00",
            "10:00-12:00",
            "10:00-12:00 & 13:00-16:00 & 18:00-21:00",
            "10:00-12:00 & 13:00-16:00",
            null,
            null,
            "Koffie schenken",
            "/img/singularItem/koffie.png",
            "Heb je zin om gezellig tijd met andere door te brengen en onderdeel te zijn van het gezelligste koffiehuisje van ''s-Hertogenbosch. Kom dan wekelijks koffie schenken! We zoeken nog mensen voor: -Woensdag middag -Vrijdag -Zondag",
            "Ook koffie schenken",
            "Initiatief organiseren",
            "/img/singularItem/activiteit.png",
            "Heb je zin een leuk idee dat je graag wil uitvoeren. Een gezellig initiatief voor de buurt. Of gewoon een hobby die je wil delen. Organiseer dan een initiatief samen met koffietent de camping", "Begin een initiatief",
            "Help met een initiatief",
            "/img/singularItem/help.png",
            "En natuurlijk gaat geen evenement door zonder vrijwillers. Bekijk onze aankomende evenemten en geef je op",
            "Help mee",
            "Doneren",
            "/img/singularItem/doneer.png",
            "Om al onze initiatieven uit te voeren hebben we natuurlijk ook nog donaties nodig. Dit kunnen geld donaties zijn of fysieke donaties, dus heb je kopjes, een hark, vishengel of iets anders over. Doneer het dan.",
            "Doneer",
            "IGQVJWQXY3MzYwOHRyeVdUYkxKUnBiMXJaLXRhR0R4YnRYazJkRFVoMS13WnN2VHJCSldIVzNZAVVpYTTFEMFdSa0hubzFsYjczbm4xcXBXUGx4ZAFY5NEZAheHZAOV1g0Q05ZATkxFSGZAn",
            "https://www.facebook.com/campingkoffietent/",
            "https://www.instagram.com/CampingKoffietent",
            "https://twitter.com/bouwrituelen",
            "campingdenbosch@gmail.com",
            "Zuid-Willemsvaart 6,",
            "5211 NW 's-Hertogenbosch",
            "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1236.573513450271!2d5.30285192121942!3d51.69375449614447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6ef6099465195%3A0xf420c4427950c579!2sKoffietent%20%22de%20Camping%22!5e0!3m2!1snl!2snl!4v1587066265052!5m2!1snl!2snl",
            "Heb je een vraag of wil je graag iets kwijt? Kom dan gerust eens langs tijdens onze openingstijden, of stel je vraag via dit formulier!"
            ]
        ];

        $this->seed(SingularItems::class, $data);
    }
}
