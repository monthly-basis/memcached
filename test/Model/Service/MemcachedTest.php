<?php
namespace MonthlyBasis\MemcachedTest\Model\Service;

use MonthlyBasis\Memcached\Model\Service as MemcachedService;
use PHPUnit\Framework\TestCase;

class MemcachedTest extends TestCase
{
    protected function setUp(): void
    {
        $this->memcachedService = new MemcachedService\Memcached();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(MemcachedService\Memcached::class, $this->memcachedService);
    }

    public function testDelete()
    {
        /*
         * We found a bug where setting value to 'value' returns a value of NULL.
         *
         * We reported the issue here:
         * https://github.com/laminas/laminas-cache-storage-adapter-memcached/issues/5
         *
         * Subsequent setForMinutes with values of 'value' seem to work fine.
         * Therefore, only this first setForMinutes value is set to 'val' instead.
         */
        $key = 'key';
        $this->memcachedService->setForMinutes($key, 'val', 3);
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

    public function test_setNamespace()
    {
        // Reset memcached key-value pairs first.
        $this->memcachedService->setNamespace('foo');
        $this->memcachedService->delete('string');
        $this->memcachedService->setNamespace('bar');
        $this->memcachedService->delete('string');

        $this->memcachedService->setNamespace('foo');
        $this->memcachedService->setForDays('string', 'hello world from foo', 1);
        $this->assertSame(
            'hello world from foo',
            $this->memcachedService->get('string')
        );

        $this->memcachedService->setNamespace('bar');
        $this->assertNull(
            $this->memcachedService->get('string')
        );
        $this->memcachedService->setForDays('string', 'hello world from bar', 1);
        $this->assertSame(
            'hello world from bar',
            $this->memcachedService->get('string')
        );

        $this->memcachedService->setNamespace('foo');
        $this->assertSame(
            'hello world from foo',
            $this->memcachedService->get('string')
        );
    }
}
