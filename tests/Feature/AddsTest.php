<?php

namespace Tests\Feature;

use App\Models\Adds;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AddsTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /* При изменении текста объявления статус должен на 3 минуты переходить “В ожидании” */
    public function testAddsTextChanged()
    {
        $add = Adds::factory()->create();
        $text = $this->faker->text();
        $add->text = $text;
        $response = $this->put('/api/adds/'.$add->id, $add->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('adds', ['id' => $add->id, 'text' => $text, 'status' => 'В ожидании']);
        $this->assertTrue(Cache::has('cached_adds'));
        $this->assertContains($add->id, Cache::get('cached_adds'));
        $this->assertTrue(Cache::has('adds_status_'.$add->id));
    }

    /* При изменении бюджета на сумму выше 0, например если было 0 и мы поставили 5, то статус объявления из “В ожидании” должен переходить в “Активен”  */
    public function testAddsBudgetChanged()
    {
        $add = Adds::factory()->create(['status' => 'В ожидании', 'budget' => 0]);
        $response = $this->put('/api/adds/'.$add->id, $add->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('adds', ['id' => $add->id, 'status' => 'В ожидании']);
        $add->budget = $this->faker->numberBetween(1000, 10000);
        $response = $this->put('/api/adds/'.$add->id, $add->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('adds', ['id' => $add->id, 'status' => 'Активен']);

    }
}
