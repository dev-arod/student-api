<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            /* 'id' => $this->id, */
            'address' => $this->address,
            'address2' => $this->address2,
            'district' => $this->district,
            'postal_code' => $this->postal_code,
            'phone_number' => $this->phone_number,
            /* 'city_id' => $this->city_id,
            'student_id' => $this->student_id, */
        ];
    }
}
