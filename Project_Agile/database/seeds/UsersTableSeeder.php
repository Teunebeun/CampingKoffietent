<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
            [Hash::make('password'), 'Imke', 'van', 'Dillen', 'ImkeVanDillen@gmail.com', '/img/user/imke.jpg', '0612345678'],
            [Hash::make('password'), 'Ad', null, 'Min', 'admin@gmail.com', null, '0687654321']
        ];

        $this->seed(User::class, $data);
    }
}
