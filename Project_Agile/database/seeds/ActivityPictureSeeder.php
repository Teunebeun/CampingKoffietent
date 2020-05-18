<?php

use App\ActivityPicture;
use Illuminate\Database\Seeder;

class ActivityPictureSeeder extends Seeder
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
            [3, "/img/activity/act1.jpg"],
            [3, "/img/activity/act2.jpg"],
            [3, "/img/activity/act8.jpg"],
            [3, "/img/activity/act3.jpg"],
            [3, "/img/activity/act7.jpg"],
            [3, "/img/activity/act9.jpg"],
            [3, "/img/activity/act6.jpg"],
            [3, "/img/activity/act4.jpg"],
            [3, "/img/activity/act2.jpg"],
            [3, "/img/activity/act10.jpg"],
            [3, "/img/activity/act5.jpg"],
            [3, "/img/activity/act6.jpg"],
            [3, "/img/activity/act7.jpg"],
            [3, "/img/activity/act8.jpg"],
            [3, "/img/activity/act9.jpg"],
            [3, "/img/activity/act10.jpg"],
            [5, "/img/activity/act2.jpg"],
            [5, "/img/activity/act8.jpg"],
            [5, "/img/activity/act3.jpg"],
            [5, "/img/activity/act7.jpg"],
            [5, "/img/activity/act9.jpg"],
            [5, "/img/activity/act6.jpg"],
            [5, "/img/activity/act4.jpg"],
            [5, "/img/activity/act2.jpg"]
        ];

        $this->seed(ActivityPicture::class, $data);
    }
}
