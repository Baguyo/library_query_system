<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_students_user = User::where('type', '=', '0')->get();

        $all_students_user->each(function($item) {
            $student =  Student::factory()->create([
                'user_id' => $item->id,
            ]);
        });
    }
}
