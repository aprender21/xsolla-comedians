<?php

namespace Tests\Unit;

use App\Models\Comedian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComedianTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test comedian list
     *
     * @return void
     */
    public function test_comedian_list() {
        Comedian::factory()->count(10)->create();

        $response = $this->get(route('api.comedian.list'));

        $this->assertEquals(10, count(json_decode($response->getContent())));
    }

    /**
     * Test comedian create
     *
     * @return void
     */
    public function test_comedian_create() {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text(),
            'code' => $this->faker->numerify('#####'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];

        $response = $this->post(route('api.comedian.create'), $data);

        $this->assertEquals($data['name'], $response['name']);
        $this->assertEquals($data['description'], $response['description']);
        $this->assertEquals($data['code'], $response['code']);
        $this->assertEquals($data['status'], $response['status']);
    }

    /**
     * Test comedian update
     *
     * @return void
     */
    public function test_comedian_update() {
        Comedian::factory()->count(1)->create();

        $comedian = Comedian::first();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text(),
            'code' => $this->faker->numerify('#####'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];

        $this->put(route('api.comedian.update', $comedian->id), $data);

        $updatedComedian = Comedian::find($comedian->id);

        $this->assertEquals($data['name'], $updatedComedian['name']);
        $this->assertEquals($data['description'], $updatedComedian['description']);
        $this->assertEquals($data['code'], $updatedComedian['code']);
        $this->assertEquals($data['status'], $updatedComedian['status']);
    }

    /**
     * Test comedian delete
     *
     * @return void
     */
    public function test_comedian_delete() {
        Comedian::factory()->count(10)->create();

        $deleteComedian = Comedian::first();

        $this->delete(route('api.comedian.delete', $deleteComedian->id))->assertStatus(200);

        $this->assertEmpty(Comedian::find($deleteComedian->id));
    }
}
