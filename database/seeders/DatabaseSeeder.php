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
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::factory()->create([

            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),

        ]);
        $numberOfRecords = 20;

        // Define possible question numbers
        $questionNumbers = [1, 2, 3];

        // Seed data
        for ($i = 0; $i < $numberOfRecords; $i++) {
            DB::table('possible_answers')->insert([
                'answer' => 'Answer ' . ($i + 1), // Generating a unique answer text
                'question_number' => $questionNumbers[array_rand($questionNumbers)], // Randomly select a question number
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
