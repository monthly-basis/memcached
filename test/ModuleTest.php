<?php
namespace MonthlyBasis\MemcachedTest;

use MonthlyBasis\LaminasTest\ModuleTestCase;
use MonthlyBasis\Memcached\Module;
use PHPUnit\Framework\TestCase;

class ModuleTest extends ModuleTestCase
{
    protected function setUp(): void
    {
        $this->module = new Module();
    }
}
