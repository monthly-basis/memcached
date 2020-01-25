<?php
namespace LeoGalleguillos\Memcached;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                MemcachedService\Memcached::class => function ($sm) {
                    return new MemcachedService\Memcached();
                },
            ],
        ];
    }
}
