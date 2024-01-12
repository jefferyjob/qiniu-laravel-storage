<?php
namespace Tests\Unit;

use Tests\AbstractTestCase;

class ExampleTest extends AbstractTestCase
{
    // ./vendor/bin/phpunit --filter testExample ./tests/Unit/ExampleTest.php
    public function testExample()
    {
        $sum = 1 + 1;
        $this->assertEquals(2, $sum);
    }
}
