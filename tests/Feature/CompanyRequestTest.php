<?php

namespace Tests\Feature;

use App\Alias\Routes;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyRequestTest extends TestCase
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
            'name'    => $withNameFilled ? $this->faker->company : Arr::get($attributes, 'name', ''),
            'email'   => Arr::get($attributes, 'email', ''),
            'website' => Arr::get($attributes, 'website', ''),
            'logo'    => Arr::get($attributes, 'logo', ''),
        ];

        return $form;
    }

    /**
     * @test
     * @group Employees
     */
    public function check_company_new_route_logged_in()
    {
        $this->actingAs($this->user)
            ->get(route(Routes::COMPANY_NEW))
            ->assertStatus(200)
            ->assertSee('Creating a company');
    }

    /** @test */
    public function check_validation_rules()
    {
        $validation      = new CompanyRequest();
        $validationRules = $validation->rules();

        $this->assertArrayHasKey('name', $validationRules);
        $this->assertArrayHasKey('email', $validationRules);
        $this->assertArrayHasKey('website', $validationRules);
        $this->assertArrayHasKey('logo', $validationRules);

        $fields = ['name', 'email', 'website', 'logo'];
        $diff   = array_diff($fields, array_keys($validationRules));

        $this->assertSame(0, count($diff), 'Invalid validation rule');
    }

    /** @test */
    public function store_company_required_empty()
    {
        $form = $this->getForm();

        $response = $this->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);
        
        $response->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name field is required.']);

    }

    /** @test */
    public function store_company_required_filled()
    {
        $form = $this->getForm([], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $this->assertTrue($response->isRedirection());
        
        $company = Company::latest()->first();
        $response->assertLocation(route(Routes::COMPANY_VIEW, [$company->slug]));

        $this->assertSame($company->name, $form['name']);
    }

    /** @test */
    public function store_validate_invalid_email()
    {
        $form = $this->getForm(['email' => 'invalid.email.com'], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email' => 'The email format is invalid.']);
    }


    /** @test */
    public function store_validate_valid_email()
    {
        $form = $this->getForm(['email' => $this->faker->safeEmail], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $company = Company::latest()->first();
        $response->assertLocation(route(Routes::COMPANY_VIEW, [$company->slug]));

        $this->assertSame($company->name, $form['name']);
        $this->assertSame($company->email, $form['email']);
    }

    /** @test */
    public function store_validate_invalid_website()
    {
        $form = $this->getForm(['website' => 'invalid.website.com'], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['website' => 'The website format is invalid.']);
    }


    /** @test */
    public function store_validate_valid_website()
    {
        $form = $this->getForm(['website' => $this->faker->url], true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $company = Company::latest()->first();
        $response->assertLocation(route(Routes::COMPANY_VIEW, [$company->slug]));

        $this->assertSame($company->name, $form['name']);
        $this->assertSame($company->website, $form['website']);
    }

    /** @test */
    public function store_validate_invalid_logo_format_and_dimension()
    {

        $form = $this->getForm([
            'logo' => UploadedFile::fake()->image('logo.pdf', 50, 50)
        ],true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['logo' => 'The logo must be a file of type: jpeg, bmp, png.'])
            ->assertSessionHasErrors(['logo' => 'The logo has invalid image dimensions. The image needs to be minimum 100x100px']);
    }

    /** @test */
    public function store_validate_invalid_logo_format()
    {
        $form = $this->getForm([
            'logo' => UploadedFile::fake()->image('logo.pdf', 100, 100)
        ],true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['logo' => 'The logo must be a file of type: jpeg, bmp, png.']);
    }

    /** @test */
    public function store_validate_invalid_logo_dimension()
    {
        $form = $this->getForm([
            'logo' => UploadedFile::fake()->image('logo.jpg', 50, 50)
        ],true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['logo' => 'The logo has invalid image dimensions. The image needs to be minimum 100x100px']);
    }

    /** @test */
    public function store_validate_valid_logo()
    {
        Storage::fake('public');

        $form = $this->getForm([
            'logo' => UploadedFile::fake()->image('logo.jpg', 200, 200)
        ],true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $company = Company::latest()->first();
        $response->assertLocation(route(Routes::COMPANY_VIEW, [$company->slug]));

        Storage::disk('public')->assertExists('logos/'.$company->logo);
        $this->assertSame($company->name, $form['name']);
    }

    /** @test */
    public function update_validate_valid_logo()
    {
        Storage::fake('public');

        $form = $this->getForm([
            'logo' => UploadedFile::fake()->image('logo.jpg', 200, 200)
        ],true);

        $response = $this
            ->actingAs($this->user)
            ->post(route(Routes::COMPANY_SAVE), $form);

        $this->assertTrue($response->isRedirection());

        $company = Company::latest()->first();
        $response->assertLocation(route(Routes::COMPANY_VIEW, [$company->slug]));

        Storage::disk('public')->assertExists('logos/'.$company->logo);
        $this->assertSame($company->name, $form['name']);

        //----

        $form['logo'] = UploadedFile::fake()->image('logo2.jpg', 200, 200);
        $response = $this
            ->actingAs($this->user)
            ->put(route(Routes::COMPANY_UPDATE, [$company->slug]), $form);
        $this->assertTrue($response->isRedirection());
        $response->assertLocation(route(Routes::COMPANY_VIEW, [$company->slug]));

        Storage::disk('public')->assertMissing('logos/'.$company->logo);
        $company->refresh();
        Storage::disk('public')->assertExists('logos/'.$company->logo);
    }
}
