<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserCrudTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_non_admin_cannot_store_user()
    {
        $user = User::factory()->make()->toArray();
        $nonAdmin = User::factory()->create();

       $response = $this->actingAs($nonAdmin)->post(route('admin.store-user'),$user);
       $response->assertStatus(403);

    }

    public function test_admin_can_store_user()
    {
        $user = User::factory()->make()->toArray();
        $admin = User::factory()->admin()->create();

       $response = $this->actingAs($admin)->post(route('admin.store-user'),$user);
       $response->assertStatus(201);

    }
}
