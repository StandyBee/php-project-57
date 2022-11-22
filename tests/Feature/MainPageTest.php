<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainPageTest extends TestCase
{
    public function testMainPage(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertOk();
    }
}
