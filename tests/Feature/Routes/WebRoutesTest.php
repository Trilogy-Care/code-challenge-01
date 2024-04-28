<?php

namespace Feature\Routes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_web_route(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertViewIs('bills.index');
    }
}
