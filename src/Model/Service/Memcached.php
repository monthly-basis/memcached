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
    private $laminasMemcached;

    /**
     * @var LaminasMemcachedOptions
     */
    private $laminasMemcachedOptions;

    public function __construct()
    {
        $laminasMemcachedResourceManager = new LaminasMemcachedResourceManager();
        $laminasMemcachedResourceManager->addServer('default', 'localhost');

        $this->laminasMemcachedOptions = new LaminasMemcachedOptions();
        $this->laminasMemcachedOptions->setResourceManager($laminasMemcachedResourceManager);

        $this->laminasMemcached = new LaminasMemcached($this->laminasMemcachedOptions);
    }

    /**
     * @return bool
     */
    public function delete($key)
    {
        try {
            return $this->laminasMemcached->removeItem($key);
        } catch (RuntimeException $runtimeException) {
            return false;
        }
    }

    public function get($key)
    {
        try {
            return $this->laminasMemcached->getItem($key);
        } catch (RuntimeException $runtimeException) {
            return null;
        }
    }

    public function setForMinutes($key, $value, $minutes)
    {
        $this->laminasMemcachedOptions->setTtl($minutes * 60);

        try {
            $this->laminasMemcached->setItem($key, $value);
        } catch (RuntimeException $runtimeException) {
            // Do nothing.
        }
    }

    public function setForHours($key, $value, $hours)
    {
        $this->laminasMemcachedOptions->setTtl($hours * 60 * 60);

        try {
            $this->laminasMemcached->setItem($key, $value);
        } catch (RuntimeException $runtimeException) {
            // Do nothing.
        }
    }

    public function setForDays($key, $value, $days)
    {
        $this->laminasMemcachedOptions->setTtl($days * 24 * 60 * 60);

        try {
            $this->laminasMemcached->setItem($key, $value);
        } catch (RuntimeException $runtimeException) {
            // Do nothing.
        }
    }
}
