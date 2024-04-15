<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertSee(value: 'Documentation');

        $response->assertStatus(200);
    }

    public function test_the_application_contains_symphony(): void
    {
        $response = $this->get('/');

        $response->assertSee(value: 'Symphony');

        $response->assertStatus(200);
    }
}
