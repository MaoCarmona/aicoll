<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_company()
    {
        $data = [
            'nit' => '1234567890',
            'name' => 'Test Company',
            'address' => '123 Test Address',
            'phone' => '1234567890',
        ];

        $response = $this->postJson('/api/companies', $data);

        $response->assertStatus(201)
                 ->assertJson($data);

        $this->assertDatabaseHas('companies', $data);
    }

    /** @test */
    public function it_validates_the_create_company_request()
{
    $data = [
        'nit' => '',
        'name' => '',
        'address' => '',
        'phone' => '',
    ];

    $response = $this->postJson('/api/companies', $data);

    $response->assertStatus(422)
             ->assertJsonStructure([
                 'error' => [
                     'nit',
                     'name',
                     'address',
                     'phone',
                 ],
             ]);
}

    /** @test */
    public function it_can_show_a_company()
    {
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->nit}");

        $response->assertStatus(200)
                 ->assertJson($company->toArray());
    }

    /** @test */
    public function it_returns_404_if_company_not_found()
    {
        $response = $this->getJson('/api/companies/invalid-nit');

        $response->assertStatus(404)
                 ->assertJson(['error' => 'Company not found']);
    }

    /** @test */
    public function it_can_list_all_companies()
    {
        $companies = Company::factory()->count(3)->create();

        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
                 ->assertJson($companies->toArray());
    }

    /** @test */
    public function it_can_update_a_company()
    {
        $company = Company::factory()->create();

        $updateData = [
            'name' => 'Updated Company',
            'address' => '456 Updated Address',
            'phone' => '0987654321',
            'status' => 'Inactive',
        ];

        $response = $this->putJson("/api/companies/{$company->nit}", $updateData);

        $response->assertStatus(200)
                 ->assertJson($updateData);

        $this->assertDatabaseHas('companies', array_merge(['nit' => $company->nit], $updateData));
    }

    /** @test */
    public function it_does_not_allow_updating_nit()
    {
        $company = Company::factory()->create();

        $updateData = [
            'nit' => 'new-nit',
            'name' => 'Updated Company',
            'address' => '456 Updated Address',
            'phone' => '0987654321',
            'status' => 'Inactive',
        ];

        $response = $this->putJson("/api/companies/{$company->nit}", $updateData);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'NIT cannot be updated']);
    }

    /** @test */
    public function it_can_delete_an_inactive_company()
    {
        $company = Company::factory()->create(['status' => 'Inactive']);

        $response = $this->deleteJson("/api/companies/{$company->nit}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Company deleted successfully']);

        $this->assertDatabaseMissing('companies', ['nit' => $company->nit]);
    }

    /** @test */
    public function it_does_not_allow_deleting_active_company()
    {
        $company = Company::factory()->create(['status' => 'Active']);

        $response = $this->deleteJson("/api/companies/{$company->nit}");

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Only inactive companies can be deleted']);
    }
}
