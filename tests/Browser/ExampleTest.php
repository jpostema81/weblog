<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    public function setUp() :void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        // 1. Visit the home page
        // 2. Press the "Register" link
        // 3. See "Register"
        // 4. Fill in all fields
        // 5. Click "Register" Button
        // 6. Wait for "Registration successful" toast-message

        $this->browse(function (Browser $browser) {
            $browser->visit('/')->assertSee('Jeroens Weblog')
                ->pause(1000)
                ->clickLink('Register');
            
            $browser->pause(1000)
                ->type('first_name', 'Jaap')
                ->type('last_name', 'Hendriks')
                ->type('email', 'jaaphendriks@script.nl')
                ->type('password', 'jaaphendriks')
                ->type('password_confirmation', 'jaaphendriks')
                ->press('Register');

            // Wait a maximum of five seconds for the text...
            $browser->waitForText('Registration successful')
                ->pause(3000);
        });
    }
}
