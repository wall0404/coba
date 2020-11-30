<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\Self_;
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
        //Log in User
        $response = $this->json('POST', '/api/login', ['email' => 's.schmitt@example.net', 'password' => 'password']);
        $response->assertStatus(200);
        $token = json_decode($response->content())->success->token;

        //Check if Correct user is logged in
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/details');
        $response->assertStatus(200);
        self::assertEquals(json_decode($response->content())->success->user->user_id, 1);

        //Log in with incorrect password. Shouldn't be possible
        $response = $this->json('POST', '/api/login', ['email' => 's.schmitt@example.net', 'password' => 'wrong_password']);
        $response->assertStatus(401);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/details');
        //User should be logged out
        $response->assertStatus(200);
        self::assertEquals(json_decode($response->content())->success->user, null);

        //Log user in
        $response = $this->json('POST', '/api/login', ['email' => 's.schmitt@example.net', 'password' => 'password']);
        $response->assertStatus(200);
        $token = json_decode($response->content())->success->token;
        //Log out
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/logout');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/details');
        $response->assertStatus(200);
        self::assertEquals(json_decode($response->content())->success->user, null);

        //Log in with incorrect email. Shouldn't be possible
        $response = $this->json('POST', '/api/login', ['email' => 'does_not_exist@example.net', 'password' => 'password']);
        $response->assertStatus(401);
    }
}
