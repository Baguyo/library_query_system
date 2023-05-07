<?php

namespace Database\Seeders;

use Database\Factories\BookFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookCount = max( (int)$this->command->ask('How many books you want to create? ', 10), 1 );

        BookFactory::factoryForModel('book')->count($bookCount)->create();
    }
}
