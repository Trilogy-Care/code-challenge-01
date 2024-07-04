<?php

namespace Tests\Feature;

use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

use Tests\TestCase;

class BillTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_visit_bill_form()
    {
        $this
            ->get(route('bills.create'))
            ->assertOk()
            ->assertInertia(function ($assert) {
                $assert->component('Bills/Create')
                    ->has('bill_stages', 7)
                    ->has('flash.message', null)
                    ->where('errors', []);
            });
    }

    public function test_submit_valid_fields()
    {
        $this->assertDatabaseEmpty('bills');

        $this->get(route('bills.create'));

        $this
            ->followingRedirects()
            ->post('/bills', $this->validBillInput())
            ->assertOk()
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('flash.message', 'Bill added successfully!')
                    ->where('errors', []);
            });

        $data = $this->validBillInput();

        $data['bill_date'] = $data['bill_date'].' 00:00:00';

        $this->assertDatabaseHas('bills', $data);
    }

    public function test_required_fields()
    {
        $this->assertDatabaseEmpty('bills');

        $this->get(route('bills.create'));

        $data = [
            'bill_reference' => '',
            'bill_date' => '',
            'bill_stage_id' => '',
        ];

        $this
            ->followingRedirects()
            ->post('/bills', $data)
            ->assertOk()
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('errors.bill_reference', 'The bill reference field is required.')
                    ->where('errors.bill_date', 'The bill date field is required.')
                    ->where('errors.bill_stage_id', 'The bill stage field is required.');
            });

        $this->assertDatabaseEmpty('bills');
    }

    public function test_reference_max_character()
    {
        $this->assertDatabaseEmpty('bills');

        $data = $this->validBillInput();

        $data['bill_reference'] = Str::random(300);

        $this->get(route('bills.create'));

        $this
            ->followingRedirects()
            ->post('/bills', $data)
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('errors.bill_reference', 'The bill reference field must not be greater than 255 characters.');
            });

        $this->assertDatabaseEmpty('bills');
    }

    public function test_date_invalid()
    {
        $this->assertDatabaseEmpty('bills');

        $this->get(route('bills.create'));

        $data = $this->validBillInput();

        $data['bill_date'] = 'invalid-date';
        $this
            ->followingRedirects()
            ->post('/bills', $data)
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('errors.bill_date', 'The bill date field must be a valid date.');
            });

        $data['bill_date'] = '2024-30-30';
        $this
            ->followingRedirects()
            ->post('/bills', $data)
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('errors.bill_date', 'The bill date field must be a valid date.');
            });

        $this->assertDatabaseEmpty('bills');
    }

    public function test_stage_invalid()
    {
        $this->assertDatabaseEmpty('bills');

        $this->get(route('bills.create'));

        $data = $this->validBillInput();

        $data['bill_stage_id'] = 'invalid-stage-id';
        $this
            ->followingRedirects()
            ->post('/bills', $data)
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('errors.bill_stage_id', 'The bill stage field must be a number.');
            });

        $data['bill_stage_id'] = 1000000; // bill_stage_id is from 1 to 7 only
        $this
            ->followingRedirects()
            ->post('/bills', $data)
            ->assertInertia(function($assert) { 
                $assert
                    ->component('Bills/Create')
                    ->where('errors.bill_stage_id', 'The selected bill stage is invalid.');
            });

        $this->assertDatabaseEmpty('bills');
    }

    /**
     * Below are just helper functions
     */

    private function validBillInput()
    {
        return [
            'bill_reference' => 'Valid Reference',
            'bill_date' => '2024-07-04',
            'bill_stage_id' => Bill::STAGES['SUBMITTED'],
        ];
    }
}
