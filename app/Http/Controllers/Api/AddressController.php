<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressStoreRequest;
use App\Http\Requests\Api\AddressUpdateRequest;
use App\Http\Resources\Api\AddressCollection;
use App\Http\Resources\Api\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function index(Request $request): Response
    {
        $addresses = Address::all();

        return new AddressCollection($addresses);
    }

    public function store(AddressStoreRequest $request): Response
    {
        $address = Address::create($request->validated());

        return new AddressResource($address);
    }

    public function show(Request $request, Address $address): Response
    {
        return new AddressResource($address);
    }

    public function update(AddressUpdateRequest $request, Address $address): Response
    {
        $address->update($request->validated());

        return new AddressResource($address);
    }

    public function destroy(Request $request, Address $address): Response
    {
        $address->delete();

        return response()->noContent();
    }
}
