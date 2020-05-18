<?php

use App\ActivityPlanned;
use App\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
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
            [1, "Martijn", null, "Steen", "Marti@gmail.com", "0615487932", "Hallo ik hou van kunst ik ben een echte liefhebber, ik zou dolgraag willen helpen", "2020-05-01 12:15:48", 0, 0],
            [1, "Jonias", "van", "Broek", "Joni@outlook.com", "0678591234", "Ik ben zo blij dat er eindelijk weer eens iets met kunst gedaan word. I AM IN", "2020-05-01 15:48:03", 0, 0],
            [2, "Priscila", null, "Pad", "Pripad@hotmail.com", "0615487932", "Ik kom graag een keertje langs om mijn vele verhalen te vertellen...", "2020-04-29 11:02:58", 0, 0],
            [5, "Inge", "van", "Doren", "Marti@gmail.com", "0678561234", "Wat een leuk idee! Ik woon om de hoek en zal binnenkort iemand ophalen!", "2020-05-03 19:45:12", 0, 0],
            [5, "Ben", "van den", "Heuvel", "Marti@gmail.com", "0612457869", "Als ouderen verzorgende komen wij graag samen een keertje langs", "2020-04-23 12:09:12", 0, 0]
        ];

        $this->seed(Application::class, $data);
    }
}
