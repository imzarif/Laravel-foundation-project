<?php

namespace App\Jobs;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Constant\AppConstant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnlockedUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;

     /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

     /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 90;

    public UserRepositoryInterface $userRepository;

    /**
     * Create a new job instance.
     * @param  App\Models\User  $user
     * @return void
     */
    public function __construct(User $user, UserRepositoryInterface $userRepository)
    {
        $this->user = $user;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->userRepository->accountUnlock($this->user->id, AppConstant::STATUS_ACTIVE);
    }
}
