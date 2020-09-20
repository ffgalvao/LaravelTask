<?php

namespace Tests\Feature;

use App\Alias\Routes;
use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class EmployeeRequestTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /** @var User */
    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function getForm(array $attributes = [], $withNameFilled = false)
    {
        $form = [
            'first_name' => $withNameFilled ? $this->faker->firstName : Arr::get($attributes, 'first_name', ''),
            'last_name'  => $withNameFilled ? $this->faker->lastName : Arr::get($attributes, 'last_name', ''),
            'email'      => Arr::get($attributes, 'email', ''),
            'phone'      => Arr::get($attributes, 'phone', ''),
            'company'    => Arr::get($attributes, 'company', ''),
        ];

        return $form;
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employee_new_route_logged_in()
    {
        $this->actingAs($this->user)
            ->get(route(Routes::EMPLOYEE_NEW))
            ->assertStatus(200)
            ->assertSee('Creating an employee');
    }

    /** @test  */
    public function check_validation_rules()
    {
        $validation      = new EmployeeRequest();
        $validationRules = $validation->rules();

        $this->assertArrayHasKey('first_name', $validationRules);
        $this->assertArrayHasKey('last_name', $validationRules);
        $this->assertArrayHasKey('email', $validationRules);
        $this->assertArrayHasKey('phone', $validationRules);
        $this->assertArrayHasKey('company', $validationRules);

        $fields = ['first_name', 'last_name', 'email', 'phone', 'company'];
        $diff = array_diff($fields, array_keys($validationRules));

        $this->assertSame(0, count($diff), 'Invalid validation rule');
    }

    /** @test */
    public function store_employee_required_empty()
    {
        $form = $this->getForm();

        $response = $this->actingAs($this->user)
            ->post(route(Routes::EMPLOYEE_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.'])
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);

    }

    /** @test */
    public function store_employee_required_filled()
    {
        $form = $this->getForm([], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::EMPLOYEE_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $employee = Employee::latest()->first();
        $response->assertLocation(route(Routes::EMPLOYEE_VIEW, [$employee->code]));

        $this->assertSame($employee->first_name, $form['first_name']);
        $this->assertSame($employee->last_name, $form['last_name']);
    }

    /** @test */
    public function store_validate_invalid_email()
    {
        $form = $this->getForm(['email' => 'invalid.email.com'], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::EMPLOYEE_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email' => 'The email format is invalid.']);
    }


    /** @test */
    public function store_validate_valid_email()
    {
        $form = $this->getForm(['email' => $this->faker->safeEmail], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::EMPLOYEE_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $employee = Employee::latest()->first();
        $response->assertLocation(route(Routes::EMPLOYEE_VIEW, [$employee->code]));

        $this->assertSame($employee->first_name, $form['first_name']);
        $this->assertSame($employee->last_name, $form['last_name']);
        $this->assertSame($employee->email, $form['email']);
    }

    /** @test */
    public function store_validate_invalid_company()
    {
        $form = $this->getForm(['company' => 'invalid_company'], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::EMPLOYEE_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['company' => 'The selected company is invalid.']);
    }

    /** @test */
    public function store_validate_valid_company()
    {
        $company = Company::factory()->create();
        $form    = $this->getForm(['company' => $company->slug], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::EMPLOYEE_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $employee = Employee::latest()->first();
        $response->assertLocation(route(Routes::EMPLOYEE_VIEW, [$employee->code]));

        $this->assertSame($employee->first_name, $form['first_name']);
        $this->assertSame($employee->last_name, $form['last_name']);
        $this->assertSame((int)$employee->company_id, (int)$company->id);
    }
}
