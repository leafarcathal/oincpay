<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTransactionTest extends TestCase
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
        ])->postJson('/api/transaction', [
            'access_code'           => $response['data']['access_code'],
            'amount'                => floatval('0.10'),
            'receiver_identifier'   => "user02@yopmail.com",
        ]);

        $response->assertStatus(200);
    }

    /**
     * Get error response when hash is invalid
     *
     * @return void
     */
    public function test_invalid_or_expired_access_code()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('/api/transaction', ['access_code' => 'invalid_access_code']);

        $response->assertStatus(401);
    }

    /**
     * Get error response when missing any required parameters (access_code, amount, receiver_identifier)
     *
     * @return void
     */
    public function test_missing_required_fields()
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
        ])->postJson('/api/transaction', [
            'access_code'           => $response['data']['access_code'],
            'receiver_identifier'   => "user02@yopmail.com",
        ]);

        $response->assertStatus(403);
    }

    /**
     * Get error response when users does not have enough funds to transfer
     *
     * @return void
     */
    public function test_not_enough_funds()
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
        ])->postJson('/api/transaction', [
            'access_code'           => $response['data']['access_code'],
            'amount'                => floatval('10000.00'),
            'receiver_identifier'   => "user02@yopmail.com",
        ]);

        $response->assertStatus(403);
    }

    /**
     * Get error response when receiver_identifier is invalid
     *
     * @return void
     */
    public function test_invalid_receiver_identifier()
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
        ])->postJson('/api/transaction', [
            'access_code'           => $response['data']['access_code'],
            'amount'                => floatval('0.10'),
            'receiver_identifier'   => "invalid_email_or_document@yopmail.com",
        ]);

        $response->assertStatus(403);
    }

    /**
     * Get error response when one user tries to send funds to their own wallet
     *
     * @return void
     */
    public function test_send_funds_to_user_own_wallet()
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
        ])->postJson('/api/transaction', [
            'access_code'           => $response['data']['access_code'],
            'amount'                => floatval('0.10'),
            'receiver_identifier'   => "user01@yopmail.com",
        ]);

        $response->assertStatus(403);
    }
}
