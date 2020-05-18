<?php

use App\CampingbaasActivityPlanned;
use Illuminate\Database\Seeder;

class CampingbaasActivityPlannedSeeder extends Seeder
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
            [1,2],
            [1,3],
            [1,4],
            [2,2],
            [2,3],
            [3,4],
            [4,2],
            [4,3],
            [4,4],
            [5,1]
        ];

        $this->seed(CampingbaasActivityPlanned::class, $data);
    }
}
