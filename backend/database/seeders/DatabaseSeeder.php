<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barcode;
use App\Models\Trashtype;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Barcode::factory()->count(20)->create();

        $trashtypes = Trashtype::all();

        Barcode::all()->each(function ($user) use ($trashtypes) { 
            $user->trashtypes()->attach(
                $trashtypes->random(rand(1, 2))->pluck('id')->toArray()
            ); 
        });
    }
}
