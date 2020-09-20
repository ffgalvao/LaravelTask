<?php

namespace Tests\Feature;

use App\Models\Employee;
use Tests\TestCase;

class EmployeeModelTest extends TestCase
{
    public function test_check_fillable_fields()
    {
        $employee = new Employee();
        $expected = ['first_name', 'last_name', 'email', 'phone', 'company_id'];
        $diff     = array_diff($expected, $employee->getFillable());

        $this->assertEquals(0, count($diff));
    }
}
