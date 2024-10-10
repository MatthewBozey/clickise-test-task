<?php

namespace Tests\Feature;

use App\Models\Adds;
use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testCompanyIndex()
    {
        $response = $this->get('/api/companies');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => ['id', 'company_name', 'user' => ['id', 'name', 'email']]]]);
    }

    public function testUpdateCompanyStatus()
    {
        $company = Company::factory()->create(['status' => 'В архиве']);
        $adds = Adds::factory()->count(5)->create(['company_id' => $company->id, 'status' => 'Активен']);
        $company->status = 'В ожидании';
        $response = $this->put('/api/companies/'.$company->id, $company->toArray());
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id', 'company_name', 'user' => ['id', 'name', 'email']]]);
        $this->assertDatabaseHas('companies', ['id' => $company->id, 'status' => 'В ожидании']);
        $adds->each(function ($add) use ($company) {
            $this->assertDatabaseHas('adds', ['company_id' => $company->id, 'id' => $add->id, 'status' => 'В ожидании']);
        });
    }
}
