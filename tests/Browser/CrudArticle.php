<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CrudArticle extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', "aaa@aaa.aaa")
                ->type('password', 'aaa@aaa.aaa')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
