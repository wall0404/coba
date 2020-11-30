<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test successfull login and false login
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->json('POST', '/api/login', ['email' => 's.schmitt@example.net', 'password' => 'password']);
        $response->assertStatus(200);

        $token = json_decode($response->content())->success->token;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/details');
        $response->assertStatus(200);
        self::assertEquals(json_decode($response->content())->success->user_id, 1);


        $response = $this->json('POST', '/api/login', ['email' => 's.schmitt@example.net', 'password' => 'wrong_password']);
        $response->assertStatus(401);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/details');
        $response->assertStatus(401);

        $response = $this->json('POST', '/api/login', ['email' => 'does_not_exist@example.net', 'password' => 'password']);
        $response->assertStatus(401);
    }
}
