<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PlatformSmokeTest extends TestCase
{
    public function test_admin_dashboard_renders_for_admin(): void
    {
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Operations dashboard');
    }

    public function test_investor_dashboard_renders_seeded_investments(): void
    {
        $investor = User::where('email', 'investor@example.com')->firstOrFail();

        $this->actingAs($investor)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Active Investments');
    }

    public function test_project_details_renders_investment_entry(): void
    {
        $this->get('/projects/cultivated-crop-land-mango-4')
            ->assertOk()
            ->assertSee('Invest Now');
    }
}
