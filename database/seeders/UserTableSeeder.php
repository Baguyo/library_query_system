<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = max( (int)$this->command->ask('How many user you want to create? ', 10), 1 );

        UserFactory::factoryForModel('user')->admin()->create();
        UserFactory::factoryForModel('user')->student()->create();
        UserFactory::factoryForModel('user')->count($userCount)->create();
    }
}
