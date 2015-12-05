<?php

/**
 * This file is part of cache-bundle
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Cache;

use Doctrine\Common\Cache\Cache;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class DoctrineCacheBridge implements Cache
{
    /**
     * @type CacheItemPoolInterface
     */
    private $cachePool;

    /**
     * DoctrineCacheBridge constructor.
     *
     * @param CacheItemPoolInterface $cachePool
     */
    public function __construct(CacheItemPoolInterface $cachePool)
    {
        $this->cachePool = $cachePool;
    }

    /**
     * @param string $id
     *
     * @return \Psr\Cache\CacheItemInterface
     */
    public function fetch($id)
    {
        return $this->cachePool->getItem($id)->get();
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function contains($id)
    {
        return $this->cachePool->hasItem($id);
    }

    /**
     * @param string $id
     * @param mixed  $data
     * @param int    $lifeTime
     *
     * @return bool
     */
    public function save($id, $data, $lifeTime = 0)
    {
        $item = $this->cachePool->getItem($id);
        $item->set($data);

        if ($lifeTime !== 0) {
            $item->expiresAfter($lifeTime);
        }

        return $this->cachePool->save($item);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->cachePool->deleteItem($id);
    }

    /**
     * @return CacheItemPoolInterface
     */
    public function getCachePool()
    {
        return $this->cachePool;
    }

    /**
     * {@inheritDoc}}
     */
    public function getStats()
    {
        // Not possible, as of yet
    }
}
