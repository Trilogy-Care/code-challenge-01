<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class TriageSubmittedBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:triage-submitted-bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign submitted bills amongst users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $unassigned_bills = Bill::query()
            ->doesntHave('users')
            ->byStageLabel('submitted')
            ->get();

        if ($unassigned_bills->isEmpty()) {
            $this->info('No unassigned submitted bills found.');

            return CommandAlias::SUCCESS;
        }

        $this->info($unassigned_bills->count().' unassigned submitted bills found. Assigning...');

        $users = User::all();

        foreach ($unassigned_bills as $index => $bill) {
            // break if each user has been reached three times
            if ($index + 1 > $users->count() * 3) {
                $this->warn(($unassigned_bills->count() - $index).' bills could not be assigned as the maximum amount of bills assigned to each user has been reached.');

                return CommandAlias::SUCCESS;
            } else {
                $user = $users->get($index % $users->count());
                $bill->users()->attach($user);
                $bill->save();
            }
        }

        $this->info('All unassigned submitted bills have been assigned.');

        return CommandAlias::SUCCESS;
    }
}
