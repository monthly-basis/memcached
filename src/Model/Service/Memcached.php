<?php
namespace MonthlyBasis\Memcached\Model\Service;

use Laminas\Cache\Exception\RuntimeException;
use Laminas\Cache\Storage\Adapter\Memcached as LaminasMemcached;
use Laminas\Cache\Storage\Adapter\MemcachedOptions as LaminasMemcachedOptions;
use Laminas\Cache\Storage\Adapter\MemcachedResourceManager as LaminasMemcachedResourceManager;

class Memcached
{
    /**
     * @var LaminasMemcached
     */
    private $zendMemcached;

    /**
     * @var LaminasMemcachedOptions
     */
    private $zendMemcachedOptions;

    public function __construct()
    {
        $zendMemcachedResourceManager = new LaminasMemcachedResourceManager();
        $zendMemcachedResourceManager->addServer('default', 'localhost');

        $this->zendMemcachedOptions = new LaminasMemcachedOptions();
        $this->zendMemcachedOptions->setResourceManager($zendMemcachedResourceManager);

        $this->zendMemcached = new LaminasMemcached($this->zendMemcachedOptions);
    }

    /**
     * @return bool
     */
    public function delete($key)
    {
        try {
            return $this->zendMemcached->removeItem($key);
        } catch (RuntimeException $runtimeException) {
            return false;
        }
    }

    public function get($key)
    {
        try {
            return $this->zendMemcached->getItem($key);
        } catch (RuntimeException $runtimeException) {
            return null;
        }
    }

    public function setForMinutes($key, $value, $minutes)
    {
        $this->zendMemcachedOptions->setTtl($minutes * 60);

        try {
            $this->zendMemcached->setItem($key, $value);
        } catch (RuntimeException $runtimeException) {
            // Do nothing.
        }
    }

    public function setForHours($key, $value, $hours)
    {
        $this->zendMemcachedOptions->setTtl($hours * 60 * 60);

        try {
            $this->zendMemcached->setItem($key, $value);
        } catch (RuntimeException $runtimeException) {
            // Do nothing.
        }
    }

    public function setForDays($key, $value, $days)
    {
        $this->zendMemcachedOptions->setTtl($days * 24 * 60 * 60);

        try {
            $this->zendMemcached->setItem($key, $value);
        } catch (RuntimeException $runtimeException) {
            // Do nothing.
        }
    }
}
