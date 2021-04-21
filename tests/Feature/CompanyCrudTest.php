<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Models\User;

class CompanyCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_create_company()
    {
        $company = Company::factory()->make()->toArray();
        $user = User::factory()->create();

       $response = $this->actingAs($user)->post(route('admin.store-company'),$company);
       $response->assertStatus(403);

    }
}
