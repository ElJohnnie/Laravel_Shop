<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\User;

class UserTest extends TestCase
{
    /** @test */
    public function check_if_user_model_has_correctly()
    {
        $user = new User;

        $expect = [
            'name', 'email', 'cpf', 'password', 'admin', 'phone', 'celfone', 'cep', 'address', 'complement', 'number', 'district', 'city', 'state', 'country',
        ];

        $arrayCompared = array_diff($expect, $user->getFillable());

        $this->assertEquals(0, count($arrayCompared));
    }
}
