<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type("#email", "aaa@aaa.aaa")
                ->type("#password", 'aaa@aaa.aaa')
                ->press('Login')
                ->assertPathIs('/home');
        });


        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type("#email", "aaa@aaa.aaa")
                ->type("#password", 'aaa@aaa.aaa')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
