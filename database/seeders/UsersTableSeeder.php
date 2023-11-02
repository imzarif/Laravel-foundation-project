<?php

namespace Database\Seeders;

use App\Constant\AppConstant;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $appEnv = config('app.env');
        if ($appEnv == 'local') {
            $faker = Faker::create();
            User::insert([
                [
                    'name' => 'super Admin',
                    'ad_login' => 1,
                    'email' => 'superadmin@test.com',
                    'role_id' => 1,
                    'email_verified_at' => $faker->DateTime(),
                    'status' => AppConstant::STATUS_ACTIVE,
                ],
                [
                    'name' => 'Ariful Islam',
                    'ad_login' => 1,
                    'email' => 'ariful.islam@reddotdigitalit.com',
                    'role_id' => 1,
                    'email_verified_at' => $faker->DateTime(),
                    'status' => AppConstant::STATUS_ACTIVE,
                ],

            ]);


        }
    }
}
