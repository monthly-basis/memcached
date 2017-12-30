<?php
namespace LeoGalleguillos\Memcached\Model\Service;

use Zend\Cache\Storage\Adapter\Memcached as ZendMemcached;
use Zend\Cache\Storage\Adapter\MemcachedOptions as ZendMemcachedOptions;
use Zend\Cache\Storage\Adapter\MemcachedResourceManager as ZendMemcachedResourceManager;

class Memcached
{
    /**
     * @var ZendMemcached
     */
    private $zendMemcached;

    /**
     * @var ZendMemcachedOptions
     */
    private $zendMemcachedOptions;

    public function __construct()
    {
        $zendMemcachedResourceManager = new ZendMemcachedResourceManager();
        $zendMemcachedResourceManager->addServer('default', 'localhost');

        $this->zendMemcachedOptions = new ZendMemcachedOptions();
        $this->zendMemcachedOptions->setResourceManager($zendMemcachedResourceManager);

        $this->zendMemcached = new ZendMemcached($this->zendMemcachedOptions);
    }

    /**
     * @return bool
     */
    public function delete($key)
    {
        return $this->zendMemcached->removeItem($key);
    }

    public function get($key)
    {
        return $this->zendMemcached->getItem($key);
    }

    public function setForMinutes($key, $value, $minutes)
    {
        $this->zendMemcachedOptions->setTtl($minutes * 60);
        $this->zendMemcached->setItem($key, $value);
    }

    public function setForHours($key, $value, $hours)
    {
        $this->zendMemcachedOptions->setTtl($hours * 60 * 60);
        $this->zendMemcached->setItem($key, $value);
    }

    public function setForDays($key, $value, $days)
    {
        $this->zendMemcachedOptions->setTtl($days * 24 * 60 * 60);
        $this->zendMemcached->setItem($key, $value);
    }
}
