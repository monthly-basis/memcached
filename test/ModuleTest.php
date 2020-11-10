<?php
namespace LeoGalleguillos\MemcachedTest;

use LeoGalleguillos\Memcached\Module;
use PHPUnit\Framework\TestCase;

class MemcachedTest extends TestCase
{
    protected function setUp(): void
    {
        $this->module = new Module();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Module::class, $this->module);
    }

    public function testGetServiceConfig()
    {
        $serviceConfig = $this->module->getServiceConfig();
        $serviceConfigFactories = $serviceConfig['factories'];
        foreach ($serviceConfigFactories as $className => $value) {
            $this->assertTrue(class_exists($className));
        }
    }
}
