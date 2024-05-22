<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_return_users(): void
    {
        $users = User::get(10);
        $response = $this->getJson('/api/users');

        $response->assertJson($users->toArray());
    }
}
