<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesPermissionsSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
<<<<<<< HEAD

=======
            StatusesSeeder::class,
            CouponsSeeder::class,
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        ]);
    }
}
