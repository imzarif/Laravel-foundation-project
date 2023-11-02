<?php

namespace Database\Seeders;

use App\Constant\AppConstant;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name' => 'Business Administrator',
                'code' => AppConstant::ROLE_CODE_SUPER_ADMIN,
                'status' => AppConstant::STATUS_ACTIVE,
            ],

            [
                'name' => 'GM',
                'code' => AppConstant::ROLE_CODE_GM,
                'status' => AppConstant::STATUS_ACTIVE,
            ],

            [
                'name' => 'PM',
                'code' => AppConstant::ROLE_CODE_PM,
                'status' => AppConstant::STATUS_ACTIVE,
            ],
            [
                'name' => 'CP',
                'code' => AppConstant::ROLE_CODE_CP,
                'status' => AppConstant::STATUS_ACTIVE,
            ],
            [
                'name' => 'SPOC',
                'code' => AppConstant::ROLE_CODE_SPOC,
                'status' => AppConstant::STATUS_ACTIVE,
            ],
            [
                'name' => 'Operation',
                'code' => AppConstant::ROLE_CODE_OPERATION,
                'status' => AppConstant::STATUS_ACTIVE,
            ],
            [
                'name' => 'OSS',
                'code' => AppConstant::ROLE_CODE_OSS,
                'status' => AppConstant::STATUS_ACTIVE,
            ],
            [
                'name' => 'Vendor',
                'code' => AppConstant::ROLE_CODE_VENDOR,
                'status' => AppConstant::STATUS_ACTIVE,
            ],

        ]);
    }
}
