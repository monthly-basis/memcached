<?php
namespace LeoGalleguillos\MemcachedTest\Model\Service;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use PHPUnit\Framework\TestCase;

class MemcachedTest extends TestCase
{
    protected function setUp()
    {
        $this->memcachedService = new MemcachedService\Memcached();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(MemcachedService\Memcached::class, $this->memcachedService);
    }

    public function testDelete()
    {
        $key = 'key';
        $this->memcachedService->setForMinutes($key, 'value', 3);
        $this->assertTrue(
            $this->memcachedService->delete($key)
        );
        $this->assertFalse(
            $this->memcachedService->delete($key)
        );
    }

    public function testGet()
    {
        $this->memcachedService->setForMinutes('key', 'value', 3);
        $this->assertSame(
            'value',
            $this->memcachedService->get('key')
        );
    }

    public function testSetForMinutes()
    {
        $key   = 'key_for_minutes';
        $value = 'value for minutes';
        $this->memcachedService->setForMinutes($key,  $value, 3);
        $this->assertSame(
            $value,
            $this->memcachedService->get($key)
        );
    }

    public function testSetForHours()
    {
        $key   = 'key_for_hours';
        $value = 'value for hours';
        $this->memcachedService->setForHours($key,  $value, 3);
        $this->assertSame(
            $value,
            $this->memcachedService->get($key)
        );
    }

    public function testSetForDays()
    {
        $key   = 'key_for_days';
        $value = 'value for days';
        $this->memcachedService->setForDays($key,  $value, 3);
        $this->assertSame(
            $value,
            $this->memcachedService->get($key)
        );
    }
}
