<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\City;
use App\Models\Student;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address,
            'address2' => $this->faker->secondaryAddress,
            'district' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'postal_code' => $this->faker->postcode,
            'phone_number' => $this->faker->phoneNumber,
            'city_id' => City::factory(),
            'student_id' => Student::factory(),
        ];
    }
}
