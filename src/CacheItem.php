<?php

namespace Aequasi\Cache;

use Psr\Cache\CacheItemInterface;

/**
 *
 * @author Aaron Scherer <aequasi@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheItem implements CacheItemInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var \DateTime|null
     */
    private $expirationDate = null;

    /**
     * @var bool
     */
    private $hasValue = false;

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function isHit()
    {
        if (!$this->hasValue) {
            return false;
        }

        if ($this->expirationDate === null) {
            return true;
        }

        return ((new \DateTime) <= $this->expirationDate);
    }

    /**
     * {@inheritDoc}
     */
    public function set($value)
    {
        $this->value = $value;
        $this->hasValue = true;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function expiresAt($expiration)
    {
        $this->expirationDate = $expiration;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function expiresAfter($time)
    {
        if ($time === null) {
            $this->expirationDate = null;
        } elseif ($time instanceof \DateInterval) {
            $this->expirationDate = new \DateTime();
            $this->expirationDate->add($time);
        } else {
            $this->expirationDate = new \DateTime();
            $this->expirationDate->add(new \DateInterval('P'.$time.'S'));
        }

        return $this;
    }
}
