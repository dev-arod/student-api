<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\AddressController
 */
class AddressControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $addresses = Address::factory()->count(3)->create();

        $response = $this->get(route('address.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\AddressController::class,
            'store',
            \App\Http\Requests\Api\AddressStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $address = $this->faker->word;

        $response = $this->post(route('address.store'), [
            'address' => $address,
        ]);

        $addresses = Address::query()
            ->where('address', $address)
            ->get();
        $this->assertCount(1, $addresses);
        $address = $addresses->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $address = Address::factory()->create();

        $response = $this->get(route('address.show', $address));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\AddressController::class,
            'update',
            \App\Http\Requests\Api\AddressUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $address = Address::factory()->create();
        $address = $this->faker->word;

        $response = $this->put(route('address.update', $address), [
            'address' => $address,
        ]);

        $address->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($address, $address->address);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $address = Address::factory()->create();

        $response = $this->delete(route('address.destroy', $address));

        $response->assertNoContent();

        $this->assertModelMissing($address);
    }
}
