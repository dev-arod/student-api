<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\CountryController
 */
class CountryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $countries = Country::factory()->count(3)->create();

        $response = $this->get(route('country.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CountryController::class,
            'store',
            \App\Http\Requests\Api\CountryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $country = $this->faker->country;

        $response = $this->post(route('country.store'), [
            'country' => $country,
        ]);

        $countries = Country::query()
            ->where('country', $country)
            ->get();
        $this->assertCount(1, $countries);
        $country = $countries->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $country = Country::factory()->create();

        $response = $this->get(route('country.show', $country));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CountryController::class,
            'update',
            \App\Http\Requests\Api\CountryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $country = Country::factory()->create();
        $country = $this->faker->country;

        $response = $this->put(route('country.update', $country), [
            'country' => $country,
        ]);

        $country->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($country, $country->country);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $country = Country::factory()->create();

        $response = $this->delete(route('country.destroy', $country));

        $response->assertNoContent();

        $this->assertModelMissing($country);
    }
}
