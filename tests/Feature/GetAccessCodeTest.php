<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAccessCodeTest extends TestCase
{
    /**
     * Get success response
     *
     * @return void
     */
    public function test_success()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'hash' => 'mLgeVH4aYah0O6y2TqZlwkinGqXBRn'
        ])->getJson('/api/authenticate');

        $response->assertStatus(200);
    }

    /**
     * Get error response when missing hash
     *
     * @return void
     */
    public function test_missing_hash()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson('/api/authenticate');

        $response->assertStatus(401);
    }

    /**
     * Get error response when hash is invalid
     *
     * @return void
     */
    public function test_invalid_hash()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson('/api/authenticate');

        $response->assertStatus(401);
    }
}
