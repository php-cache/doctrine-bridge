# PSR 6 Doctrine Bridge [![Build Status](https://travis-ci.org/php-cache/doctrine-bridge.svg)](https://travis-ci.org/php-cache/doctrine-bridge)
PSR-6 Compliant Doctrine Bridge

This library provides a PSR-6 compliant bridge between Doctrine, and a Cache Pool. The bridge implements the 
`Doctrine\Common\Cache\Cache` interface.

To use the doctrine bridge, follow the instructions below, in the Usage section.

## Installation

#### Composer

Download composer using `curl -sS https://getcomposer.org/installer | php`

Run the following:

```sh
$ composer require cache/psr-6-doctrine-bridge
```

## Usage

Note: This allows you to have an instance of `Doctrine\Common\Cache\Cache` that uses a cache pool as the cache provider
Note: This allows you to use an instance of the `Doctrine\Common\Cache\Cache` interface, while being PSR-6 compliant. 
This is useful for projects that require an implementation of `Doctrine\Common\Cache\Cache`, but you still wan't to use
PSR-6

```php
use DoctrineCacheBridge\DoctrineCacheBridge;

// Assuming $pool is an instance of \Psr\Cache\CacheItemPoolInterface
$cacheProvider = new DoctrineBridge($pool);

$cacheProvider->contains($key);
$cacheProvider->fetch($key);
$cacheProvider->save($key, $value, $ttl);
$cacheProvider->delete($key);

// Also, if you need it:
$cacheProvider->getPool(); // same as $pool
```
