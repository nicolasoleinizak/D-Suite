<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $access_token;

    public function test_user_can_login()
    {
        $email = 'admin@test.com';
        $password = 'test1234';

        $response = $this->json('POST', '/api/login', [
            'email' => $email,
            'password' => $password
        ]);

        $this->access_token = $response->access_token;

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function 


}
