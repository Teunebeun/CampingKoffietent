<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CampingbaasSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(ActivityPlannedSeeder::class);
        $this->call(VacancySeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(CampingbaasActivityPlannedSeeder::class);
        $this->call(DonationTargetSeeder::class);
        $this->call(DonationSeeder::class);
        $this->call(InitiatorSeeder::class);
        $this->call(InitiativeSeeder::class);
        $this->call(SingularItemsSeeder::class);
        $this->call(SponsorSeeder::class);
        $this->call(ActivityPictureSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FooterLinkSeeder::class);
    }
}
