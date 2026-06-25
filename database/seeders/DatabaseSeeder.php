<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Coupon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(WhyChooseUsTitleSeeder::class);
        Slider::factory(3)->create();
        WhyChooseUs::factory(3)->create();
        $this->call(CategorySeeder::class);
        // php artisan tinker et  \App\Models\Product::factory(5)->create()
        Product::factory(10)->create();
        Coupon::factory(3)->create();
        
    }
}
