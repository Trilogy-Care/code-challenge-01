<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;

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
        $submitted_stage_id = BillStage::where('name', 'Submitted')->first();


        /**
         * SELECT bills.* FROM bills
         * JOIN laravel.bill_stages submitted_stage ON bills.bill_stage_id = submitted_stage.id AND submitted_stage.label = 'Submitted'
         * WHERE bill_stage_id = submitted_stage.id
         * AND bills.id NOT IN (SELECT id FROM bill_user);
         */

        $available_bills = Bill::query()
            ->join(BillStage::class, 'bills.bill_stage_id', '=', 'bills_stage.id', 'inner', ['label' => 'Submitted'])
            ->where('bills.bill_stage_id', 'bill_stage_id.id')
            ->whereNotIn('bills.id', DB::table('bill_user', 'bu'));

        $this->info($available_bills->count() . ' bills found to assign');
    }
}
