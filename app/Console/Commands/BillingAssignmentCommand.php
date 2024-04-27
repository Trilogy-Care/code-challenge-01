<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\User;
use App\Services\UserBillingService;
use App\Services\UserService;
use Illuminate\Console\Command;

class BillingAssignmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:assign';

    /**
     * @var UserBillingService
     */
    protected UserBillingService $userBillingService;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();

        $this->userBillingService = UserBillingService::new();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unassignedBills = $this->userBillingService
            ->getUnassignedBillsQuery()
            ->get();

        $assignedCount = 0;

        $unassignedBills->each(function (Bill $bill) use (&$assignedCount) {
            $user = $this->userBillingService
                ->getUsersWithoutMaxBillsQuery()
                ->inRandomOrder()
                ->first();

            if (!$user) {
                $this->warn('No users available to assign bills to.');

                return;
            }

            $bill->users()->attach($user);

            $assignedCount++;
        });

        $this->info(sprintf('%d bills have been assigned to users.', $assignedCount));
    }
}
