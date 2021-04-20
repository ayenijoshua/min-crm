<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;

class AuthenticateCompany extends TestCase
{
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/company-login');

        $response->assertStatus(200);
    }
}
