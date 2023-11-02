<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Constant\AppConstant;
use App\Models\PartnerProfile;
use Illuminate\Console\Command;
use App\Models\RobiHRSupervisor;
use Illuminate\Support\Facades\Hash;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superadmin {userEmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an user super admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('userEmail');

        $teams = Team::all();

        $teamIDs = array();
        foreach ($teams as $team) {
            array_push($teamIDs, $team->id);
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $email)->first();

            if (empty($user->id)) {
                $hrData = RobiHRSupervisor::where('email', $email)->first();
                $name = isset($hrData->name) ? $hrData->name : strstr($email, '@', true);
                $mobile = isset($hrData->mobile) ? $hrData->mobile : 'N/A';

                $user = User::create([
                    'name'     => $name,
                    'role_id'  => Role::getId(AppConstant::ROLE_CODE_SUPER_ADMIN),
                    'email'    => $email,
                    'ad_login' => true,
                    'team_permissions' => $teamIDs
                ]);
                $user->markEmailAsVerified();

                PartnerProfile::createInternalUserProfile($user->id, $name, $email, $mobile);
                echo "Super admin user created successfully";
            } else {
                $user->role_id = Role::getId(AppConstant::ROLE_CODE_SUPER_ADMIN);
                $user->team_permissions = $teamIDs;
                $user->save();
                echo "User role changed to super admin successfully";
            }
        } else {
            echo "Not a valid email";
        }
        return 0;
    }
}
