<?php

namespace Tests\Feature;

use App\Alias\Routes;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }


    /**
     * @test
     * @group Company
     */
    public function check_access_not_logged_in()
    {
        $this->get(route(Routes::DASHBOARD))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Company
     */
    public function check_access_logged_in()
    {
        $this->actingAs($this->user)
            ->get(route(Routes::DASHBOARD))
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }

    /**
     * @test
     * @group Company
     */
    public function check_companies_route_not_logged_in()
    {
        $this->get(route(Routes::COMPANIES))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Company
     */
    public function check_companies_route_logged_in()
    {
        $this->actingAs($this->user)
            ->get(route(Routes::COMPANIES))
            ->assertStatus(200)
            ->assertSee('Companies List');
    }

    /**
     * @test
     * @group Company
     */
    public function check_company_new_route_not_logged_in()
    {
        $this->get(route(Routes::COMPANY_NEW))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Company
     */
    public function check_company_new_route_logged_in()
    {
        $this->actingAs($this->user)
            ->get(route(Routes::COMPANY_NEW))
            ->assertStatus(200)
            ->assertSee('Creating a company');
    }

    /**
     * @test
     * @group Company
     */
    public function check_company_view_route_not_logged_in()
    {
        $company = Company::factory()->create();
        $this->get(route(Routes::COMPANY_VIEW, [$company->slug]))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Company
     */
    public function check_company_view_route_logged_in()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->user)
            ->get(route(Routes::COMPANY_VIEW, [$company->slug]))
            ->assertStatus(200)
            ->assertSee('Company ' . $company->name);
    }

    /**
     * @test
     * @group Company
     */
    public function check_company_edit_route_not_logged_in()
    {
        $company = Company::factory()->create();
        $this->get(route(Routes::COMPANY_EDIT, [$company->slug]))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Company
     */
    public function check_company_edit_route_logged_in()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->user)
            ->get(route(Routes::COMPANY_EDIT, [$company->slug]))
            ->assertStatus(200)
            ->assertSee('Editing ');
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employees_route_not_logged_in()
    {
        $this->get(route(Routes::EMPLOYEES))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employees_route_logged_in()
    {
        $this->actingAs($this->user)
            ->get(route(Routes::EMPLOYEES))
            ->assertStatus(200)
            ->assertSee('Employees List');
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employee_new_route_not_logged_in()
    {
        $this->get(route(Routes::EMPLOYEE_NEW))
            ->assertRedirect(route(Routes::LOGIN));
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


    /**
     * @test
     * @group Employees
     */
    public function check_employee_view_route_not_logged_in()
    {
        $employee = Employee::factory()->create();
        $this->get(route(Routes::EMPLOYEE_VIEW, [$employee->code]))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employee_view_route_logged_in()
    {
        $employee = Employee::factory()->create();
        $this->actingAs($this->user)
            ->get(route(Routes::EMPLOYEE_VIEW, [$employee->code]))
            ->assertStatus(200)
            ->assertSee('Employee ' . $employee->full_name);
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employee_edit_route_not_logged_in()
    {
        $employee = Employee::factory()->create();
        $this->get(route(Routes::EMPLOYEE_EDIT, [$employee->code]))
            ->assertRedirect(route(Routes::LOGIN));
    }

    /**
     * @test
     * @group Employees
     */
    public function check_employee_edit_route_logged_in()
    {
        $employee = Employee::factory()->create();
        $this->actingAs($this->user)
            ->get(route(Routes::EMPLOYEE_EDIT, [$employee->code]))
            ->assertStatus(200)
            ->assertSee('Editing employee');
    }


}
