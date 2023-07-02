<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\StudentController
 */
class StudentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $students = Student::factory()->count(3)->create();

        $response = $this->get(route('student.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\StudentController::class,
            'store',
            \App\Http\Requests\Api\StudentStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $email = $this->faker->safeEmail;

        $response = $this->post(route('student.store'), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
        ]);

        $students = Student::query()
            ->where('first_name', $first_name)
            ->where('last_name', $last_name)
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $students);
        $student = $students->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $student = Student::factory()->create();

        $response = $this->get(route('student.show', $student));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\StudentController::class,
            'update',
            \App\Http\Requests\Api\StudentUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $student = Student::factory()->create();
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $email = $this->faker->safeEmail;

        $response = $this->put(route('student.update', $student), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
        ]);

        $student->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($first_name, $student->first_name);
        $this->assertEquals($last_name, $student->last_name);
        $this->assertEquals($email, $student->email);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $student = Student::factory()->create();

        $response = $this->delete(route('student.destroy', $student));

        $response->assertNoContent();

        $this->assertModelMissing($student);
    }
}
