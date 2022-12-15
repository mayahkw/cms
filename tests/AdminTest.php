<?php

namespace Mayahkw\Admin\Tests;

use Mayahkw\Admin\MyAdminClass;
use Orchestra\Testbench\TestCase;

class AdminTest extends TestCase
{

    /** @test */
    function its_ok()
    {
        $this->assertEquals(
            'Cargar menu',
            MyAdminClass::menu()
        );
    }
}
