<?php

namespace Aequasi\Cache\CacheItem;

use Aequasi\Cache\CacheItem;

class CacheItemTest extends \PHPUnit_Framework_TestCase
{
    public function testHit()
    {
        $item = new CacheItem();
        $this->assertFalse($item->isHit());

        $item->set('foobar');
        $this->assertTrue($item->isHit());

        $item->set(null);
        $this->assertTrue($item->isHit());
    }
}
