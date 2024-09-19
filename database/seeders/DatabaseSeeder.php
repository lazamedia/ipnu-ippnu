<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder untuk role dan permission
        $this->call(RolesAndPermissionsSeeder::class);

        // Panggil seeder untuk user dan role
        $this->call(UserRoleSeeder::class);

        Category::create([
            'name' => 'IPNU-IPPNU',
            'slug' => 'ipnu-ippnu'
           
        ]);

        Category::create([
           'name' => 'Event',
           'slug' => 'event-ipnu'
          
       ]);

        Category::create([
            'name' => 'Ramadhan',
            'slug' => 'ramadhans'
           
        ]);
    }
}
  