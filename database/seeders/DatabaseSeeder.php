<?php

namespace Database\Seeders;

use App\Models\ConceptBasic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $appEnv = config('app.env');
        if ($appEnv == 'production') {
            exit('DB Seed Disable In Production');
        }

        $this->call([
            UsersTableSeeder::class,
            RolesSeeder::class
        ]);
    }
}
