<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Console\Command;

class AssignBills extends Command
{
    protected $signature = 'app:assign-bills';
    protected $description = 'This command will automatically assign all bills that currently not assigned and in stage "submitted" to a user. A user should only have a maximum of 3 bills assigned to them.';
    private $max_bills_per_user = 3;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::withCount(['submittedBills'])
            ->when(app()->env == 'testing', function($q) { // adding this due to testing error when using sqlite
                $q->groupBy('users.id');
            })
            ->having('submitted_bills_count', '<', 3)
            ->get();

        foreach ($users as $user) {

            $lacking_assign_count = $this->max_bills_per_user - $user->submitted_bills_count;

            $unassign_bill_ids = Bill::where('bill_stage_id', Bill::STAGES['SUBMITTED'])
                ->whereDoesntHave('users')
                ->take($lacking_assign_count)
                ->pluck('id')
                ->toArray();

            if(!count($unassign_bill_ids)) break; // All 'submitted' bills are all assigned already

            $user->bills()->attach($unassign_bill_ids);

            $this->info(count($unassign_bill_ids).' bills assigned to user '.$user->name);
        }

        $this->info('Bills assignment done.');
    }
}
