<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CityStoreRequest;
use App\Http\Requests\Api\CityUpdateRequest;
use App\Http\Resources\Api\CityCollection;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::all();

        return new CityCollection($cities);
    }

    public function store(CityStoreRequest $request): Response
    {
        $city = City::create($request->validated());

        return new CityResource($city);
    }

    public function show(Request $request, City $city): Response
    {
        return new CityResource($city);
    }

    public function update(CityUpdateRequest $request, City $city): Response
    {
        $city->update($request->validated());

        return new CityResource($city);
    }

    public function destroy(Request $request, City $city): Response
    {
        $city->delete();

        return response()->noContent();
    }
}
