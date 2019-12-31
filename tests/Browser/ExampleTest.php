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
        // 1. Visit the home page
        // 2. Press the "Register" link
        // 3. See "Register"
        // 4. Fill in all fields
        // 5. Click "Register" Button
        // 6. ...
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Jeroens Weblog');

                    $browser->pause(5000);
        });
    }
}
