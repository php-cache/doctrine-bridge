# psr-6-doctrine-bridge
PSR-6 Compliant Doctrine Bridge

This library provides a PSR-6 compliant cache implementation, and it also provides a bridge between Doctrine, and the Cache Pool

To use the doctrine bridge, follow the instructions below, in the Usage section.

## Installation

##### Todo

## Usage

#### To use the cache pool

```php
use Aequasi\Cache\CachePool;
use Doctrine\Common\Cache\RedisCache;

$predisClient = new Predis();
$cache        = new RedisCache($predisClient);
$pool         = new CachePool($cache);

$pool->getItem($key);
$pool->hasItem($key);
$pool->deleteItem($key);
$pool->save($cacheItem);
```


#### To use the Doctrine Bridge:

Note: This allows you to use an instance of the `Doctrine\Common\Cache\Cache` interface, while being PSR-6 compliant. 
This is useful for projects that require an implementation of `Doctrine\Common\Cache\Cache`, but you still wan't to use
PSR-6

Notice, no cache pool is created by the user. That is handled by [`DoctrineBridge`](src/DoctrineCacheBridge.php)
```php
use Aequasi\Cache\DoctrineBridge;
use Doctrine\Common\Cache\RedisCache;

$predisClient  = new Predis();
$cache         = new RedisCache($predisClient);
$pool          = new CachePool($cache);
$cacheProvider = new DoctrineBridge($pool);

$cacheProvider->contains($key);
$cacheProvider->fetch($key);
$cacheProvider->save($key, $value, $ttl);
$cacheProvider->delete($key);
```