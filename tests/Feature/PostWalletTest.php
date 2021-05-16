<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostWalletTest extends TestCase
{
    /**
     * Get success response
     * Requires a valid access code generated
     *
     * @return void
     */
    public function test_success()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'hash' => 'mLgeVH4aYah0O6y2TqZlwkinGqXBRn'
        ])->getJson('/api/authenticate');

        if(is_null($response['data']['access_code'])){
            $response->assertStatus(500);
        }

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('/api/wallet', ['access_code' => $response['data']['access_code']]);

        $response->assertStatus(200);
    }

    /**
     * Get error response when missing hash
     *
     * @return void
     */
    public function test_missing_access_code()
    {

    $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('/api/wallet', []);

        $response->assertStatus(403);
    }

    /**
     * Get error response when hash is invalid or expired 
     *
     * @return void
     */
    public function test_invalid_or_expired_access_code()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('/api/wallet', ['access_code' => 'invalid_access_code']);

        $response->assertStatus(401);
    }

}
