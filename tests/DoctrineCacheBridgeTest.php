<?php

/*
 * This file is part of php-cache\doctrine-bridge package.
 *
 * (c) 2015-2015 Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Cache\Bridge\Tests;

use Cache\Bridge\DoctrineCacheBridge;
use Mockery as m;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class DoctrineCacheBridgeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @type DoctrineCacheBridge
     */
    private $bridge;

    /**
     * @type m\MockInterface|CacheItemPoolInterface
     */
    private $mock;

    /**
     * @type m\MockInterface|CacheItemInterface
     */
    private $itemMock;

    protected function setUp()
    {
        parent::setUp();

        $this->mock   = m::mock(CacheItemPoolInterface::class);
        $this->bridge = new DoctrineCacheBridge($this->mock);

        $this->itemMock = m::mock(CacheItemInterface::class);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(DoctrineCacheBridge::class, $this->bridge);
    }

    public function testFetch()
    {
        $this->itemMock->shouldReceive('get')->times(2)->andReturn(null, 'some_value');

        $this->mock->shouldReceive('getItem')->withArgs(['no_item'])->andReturn($this->itemMock);
        $this->mock->shouldReceive('getItem')->withArgs(['some_item'])->andReturn($this->itemMock);

        $this->assertEmpty($this->bridge->fetch('no_item'));
        $this->assertEquals('some_value', $this->bridge->fetch('some_item'));
    }

    public function testContains()
    {
        $this->mock->shouldReceive('hasItem')->withArgs(['no_item'])->andReturn(false);
        $this->mock->shouldReceive('hasItem')->withArgs(['some_item'])->andReturn(true);

        $this->assertFalse($this->bridge->contains('no_item'));
        $this->assertTrue($this->bridge->contains('some_item'));
    }

    public function testSave()
    {
        $this->itemMock->shouldReceive('set')->twice()->with('dummy_data');
        $this->itemMock->shouldReceive('expiresAfter')->once()->with(2);
        $this->mock->shouldReceive('getItem')->twice()->with('some_item')->andReturn($this->itemMock);
        $this->mock->shouldReceive('save')->twice()->with($this->itemMock)->andReturn(true);

        $this->assertTrue($this->bridge->save('some_item', 'dummy_data'));
        $this->assertTrue($this->bridge->save('some_item', 'dummy_data', 2));
    }

    public function testDelete()
    {
        $this->mock->shouldReceive('deleteItem')->once()->with('some_item')->andReturn(true);

        $this->assertTrue($this->bridge->delete('some_item'));
    }

    public function testGetCache()
    {
        $this->assertInstanceOf(CacheItemPoolInterface::class, $this->bridge->getCachePool());
    }

    public function testGetStats()
    {
        $this->assertEmpty($this->bridge->getStats());
    }
}
