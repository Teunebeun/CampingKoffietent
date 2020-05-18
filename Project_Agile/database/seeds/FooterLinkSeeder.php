<?php

use App\FooterLink;
use Illuminate\Database\Seeder;

class FooterLinkSeeder extends Seeder
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
            ["Bossche brugwachtershuisjes",  "https://www.bosschebrugwachtershuisjes.nl/"],
            ["Weeshuisjes", "https://www.weeshuisjes.nl/"]
        ];

        $this->seed(FooterLink::class, $data);
    }
}
