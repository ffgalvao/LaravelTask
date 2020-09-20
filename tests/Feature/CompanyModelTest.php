<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyModelTest extends TestCase
{
    public function test_check_fillable_fields()
    {
        $company = new Company();
        $expected = ['name','email','website','logo'];
        $diff = array_diff($expected, $company->getFillable());

        $this->assertEquals(0, count($diff));
    }

}
