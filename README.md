# psr-6-doctrine-bridge
PSR-6 Compliant Doctrine Bridge


This library provides a bridge between Doctrine, and a PSR-6 compliant cache implementation

## Installation

##### Todo

## Usage

```php
use Aequasi\DoctrineBridge\DoctrineBridge;

$predisClient = new Predis();
$cache = new RedisCache($predisClient)
$cacheProvider = new DoctrineBridge($cache);

$cacheProvider->contains($key);
$cacheProvider->fetch($key);
$cacheProvider->save($key, $value, $ttl);
$cacheProvider->delete($key);
```