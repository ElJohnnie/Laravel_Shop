<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /** @test */
    public function register_user_failure_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('email', 'johnfollmer@teste.com')
                    ->type('password', 'blablabla')
                    ->type('cpf', '12312312323')
                    ->press('submit')
                    ->assertPathIs('/register');
        });
    }
}
