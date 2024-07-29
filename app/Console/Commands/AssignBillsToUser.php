<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use App\Rules\UserBillLimit;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AssignBillsToUser extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-bills-to-user {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigns submitted bills to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $user_id = $this->argument('user');
        $user = User::find($user_id);
        if (!$user) {
            $this->error('No user found with id '.$user_id);
        }
        $submitted_stage = BillStage::where('label', 'Submitted')->first();
        $available_bills = Bill::doesntHave('users')->where('bill_stage_id', $submitted_stage->id);

        $assigned_count = 0;
        foreach ($available_bills->get() as $available_bill) {
            if ($user->bills()->count() >= 3) {
                $this->error('Please process current bills, or assign to another user');
                return 1;
            }
            $user->bills()->attach($available_bill);
            $assigned_count++;

            // Custom validation rule a little overkill here
//            try {
                 // Repurpose user bill limit validation rule
//                (new UserBillLimit())->validate('user_id', $user->id, fn () => $this->error('Too many bills assigned for this user'));
//            } catch (ValidationException $exception) {
//            }
        }

        $this->info($assigned_count . ' Bills assigned to user');
    }
}
