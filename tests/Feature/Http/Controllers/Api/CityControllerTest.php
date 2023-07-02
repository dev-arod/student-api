<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\CityController
 */
class CityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $cities = City::factory()->count(3)->create();

        $response = $this->get(route('city.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CityController::class,
            'store',
            \App\Http\Requests\Api\CityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $city = $this->faker->city;

        $response = $this->post(route('city.store'), [
            'city' => $city,
        ]);

        $cities = City::query()
            ->where('city', $city)
            ->get();
        $this->assertCount(1, $cities);
        $city = $cities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $city = City::factory()->create();

        $response = $this->get(route('city.show', $city));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CityController::class,
            'update',
            \App\Http\Requests\Api\CityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $city = City::factory()->create();
        $city = $this->faker->city;

        $response = $this->put(route('city.update', $city), [
            'city' => $city,
        ]);

        $city->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($city, $city->city);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $city = City::factory()->create();

        $response = $this->delete(route('city.destroy', $city));

        $response->assertNoContent();

        $this->assertModelMissing($city);
    }
}
