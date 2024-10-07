<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password')
        ]);

     // Insert categories
     Category::insert([
        ['name' => 'Electronics'],
        ['name' => 'Fashion'],
        ['name' => 'Health & Beauty'],
        ['name' => 'Home & Kitchen'],
        ['name' => 'Sports & Outdoors'],
        ['name' => 'Books & Media'],
        ['name' => 'Automotive'],
        ['name' => 'Toys & Games'],
        ['name' => 'Groceries'],
        ['name' => 'Office Supplies'],
    ]);

    $this->call(ProductSeeder::class);


    }
}
