<?php

namespace Tests\Unit\Models;

use App\Models\BillStage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillStageTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Scope Tests
    |--------------------------------------------------------------------------
    */

    public function test_by_label_scope_query(): void
    {
        $result = BillStage::byLabel(BillStage::SUBMITTED)->firstOrFail();

        $this->assertNotNull($result);

        $this->assertEquals(BillStage::SUBMITTED, $result->label);
    }
}
