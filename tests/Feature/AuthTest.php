<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * Class AuthTest
 *
 * @package Tests\Feature
 */
class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test user registration endpoint.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['token']]);
    }

    /**
     * Test user login endpoint.
     *
     * @return void
     */
    public function testUserLogin()
    {
        // Create a user in the database
        User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('test@gmail.com'),
            'name' => 'Test'
        ]);

        $userData = [
            'email' => 'test@gmail.com',
            'password' => 'test@gmail.com',
        ];

        $response = $this->postJson('/api/login', $userData);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['token']]);
    }

    /**
     * Test user logout endpoint.
     *
     * @return void
     */
    public function testUserLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson('/api/logout', [], $headers);

        $response->assertStatus(200);
    }

}
