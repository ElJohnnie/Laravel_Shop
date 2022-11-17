<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /** @test */
    public function register_user_success_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Jonathan Follmer')
                    ->type('cpf', '99999999999')
                    ->type('cep', '95865000')
                    ->type('phone', '5199999999')
                    ->type('celfone', '5199999999')
                    ->type('email', 'johnfollmer@teste.com')
                    ->type('password', 'blablabla')
                    ->type('[password-confirm-data-test]', 'blablabla')
                    ->pause(3000)
                    ->press('[submit-register-data-test]')
                    ->pause(3000)
                    ->assertPathIs('/');
        });
    }
    /** @test */
    public function register_user_fail_test_wrong_confirm_password()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Jonathan Follmer')
                    ->type('cpf', '99999999999')
                    ->type('cep', '95865000')
                    ->type('phone', '5199999999')
                    ->type('celfone', '5199999999')
                    ->type('email', 'johnfollmer@teste.com')
                    ->type('password', 'blablabla')
                    ->type('[password-confirm-data-test]', 'blabla')
                    ->pause(3000)
                    ->press('[submit-register-data-test]')
                    ->pause(3000)
                    ->assertPathIs('/register');
        });
    }
}
