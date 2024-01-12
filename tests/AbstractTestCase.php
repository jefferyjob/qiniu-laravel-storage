<?php
namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use Mockery;

abstract class AbstractTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow($now = Carbon::now());
        $this->testNowTimestamp = $now->getTimestamp();
    }

    public function tearDown(): void
    {
        Carbon::setTestNow();
        Mockery::close();

        parent::tearDown();
    }

    public function createApplication()
    {
        $app = require __DIR__. '/bootstrap.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}