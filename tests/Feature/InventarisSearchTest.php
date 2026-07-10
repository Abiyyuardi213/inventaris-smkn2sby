<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventarisSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_inventaris_by_name(): void
    {
        // Seed database
        $this->seed(DatabaseSeeder::class);

        // Get super-admin user
        $user = User::where('email', 'adminutama@example.com')->first();

        // Perform search request by name "Asus"
        $response = $this->actingAs($user)
            ->get(route('inventaris.index', ['search' => 'Asus']));

        $response->assertStatus(200);
        $response->assertSee('Laptop Asus ExpertBook');
        $response->assertDontSee('RouterBoard Mikrotik CCR1009');
    }

    public function test_can_search_inventaris_by_merek(): void
    {
        // Seed database
        $this->seed(DatabaseSeeder::class);

        // Get super-admin user
        $user = User::where('email', 'adminutama@example.com')->first();

        // Perform search request by brand/merek "Mikrotik"
        $response = $this->actingAs($user)
            ->get(route('inventaris.index', ['search' => 'Mikrotik']));

        $response->assertStatus(200);
        $response->assertSee('RouterBoard Mikrotik CCR1009');
        $response->assertDontSee('Laptop Asus ExpertBook');
    }
}
