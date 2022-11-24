<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlyAdminTest extends TestCase
{
    /** @test */
    public function only_logged_admins_access_route_dashboard()
    {
        $this->get('/admin/dashboard')
            ->assertRedirect('/login');
    }
    /** @test */
    public function only_logged_admins_access_route_products()
    {
        $this->get('/admin/products')
            ->assertRedirect('/login');
    }
    /** @test */
    public function only_logged_admins_access_route_categories()
    {
        $this->get('/admin/categories')
            ->assertRedirect('/login');
    }
}
