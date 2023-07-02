<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CountryStoreRequest;
use App\Http\Requests\Api\CountryUpdateRequest;
use App\Http\Resources\Api\CountryCollection;
use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    public function index(Request $request): Response
    {
        $countries = Country::all();

        return new CountryCollection($countries);
    }

    public function store(CountryStoreRequest $request): Response
    {
        $country = Country::create($request->validated());

        return new CountryResource($country);
    }

    public function show(Request $request, Country $country): Response
    {
        return new CountryResource($country);
    }

    public function update(CountryUpdateRequest $request, Country $country): Response
    {
        $country->update($request->validated());

        return new CountryResource($country);
    }

    public function destroy(Request $request, Country $country): Response
    {
        $country->delete();

        return response()->noContent();
    }
}
