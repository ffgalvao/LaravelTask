<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_check_fillable_fields()
    {
        $user = new User();
        $expected = ['name', 'email', 'password'];
        $diff = array_diff($expected, $user->getFillable());

        $this->assertEquals(0, count($diff));
    }
}
