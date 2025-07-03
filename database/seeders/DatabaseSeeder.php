<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    private $subjects = ["Mathematics", "Romanian", "English", "French", "German", "History", "Geography", "Biology", "Physics", "Chemistry", "Computer Science", "Economics", "Logic", "Psychology", "Philosophy", "Music", "Art"];
    private $roles = ["Tutor", "Student"];
    private $type_of_teaching = ["Online", "In-person"];
    private $levels = ["Baccalaureate", "National Evaluation"];

    public function run(): void
    {
        \App\Models\User::factory()->has(\App\Models\Profile::factory())->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),
        ]);

        // Seed data
        foreach ($this->subjects as $materie) {
            DB::table('possible_answers')->insert([
                'answer' => $materie,
                'question_number' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($this->roles as $role) {
            DB::table('possible_answers')->insert([
                'answer' => $role,
                'question_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($this->type_of_teaching as $type) {
            DB::table('possible_answers')->insert([
                'answer' => $type,
                'question_number' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($this->levels as $level) {
            DB::table('possible_answers')->insert([
                'answer' => $level,
                'question_number' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
