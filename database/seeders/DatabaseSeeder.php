<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        if( $this->command->confirm( "Are you sure you want to refresh the database?", true ) ){
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserTableSeeder::class,
            StudentTableSeeder::class,
            BooksTableSeeder::class,
        ]);
    }
}
