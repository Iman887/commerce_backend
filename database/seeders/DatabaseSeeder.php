<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Imanuel',
            'email' => 'iman@gmail.com',
            'password' => bcrypt('11111111'),
            'role' => 1,
            'wa' => '081234567890',
        ]);

        Category::create(['name' => 'Fiction']);
        Category::create(['name' => 'Comics']);
        Category::create(['name' => 'Science']);
        Category::create(['name' => 'History']);
        Category::create(['name' => 'Biography']);
    }
}
