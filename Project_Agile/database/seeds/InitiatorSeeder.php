<?php

use App\Initiator;
use Illuminate\Database\Seeder;

class InitiatorSeeder extends Seeder
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
            ["Jeroen", "de", "Keizer", "jkeizer@gmail.com", '0612567891'],
            ["Loes", "van", "Vinkel", "theovanbergen@hotmail.com", '0639524718'],
            ["Teun", null, "Salters", "teunsalters@gmail.com", '0639524718']
        ];

        $this->seed(Initiator::class, $data);
    }
}
