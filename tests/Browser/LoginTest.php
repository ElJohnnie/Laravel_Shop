<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class LoginTest extends DuskTestCase
{
    // use DatabaseMigrations;

    /** @test */
    public function successful_login_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'johnfollmer@teste.com')
                    ->type('password', 'blablabla')
                    ->press('Login')
                    ->assertPathIs('/home');
        });
    }
}
