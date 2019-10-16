# PHP GitHub API

[![Build Status](https://travis-ci.org/KnpLabs/php-github-api.svg?branch=master)](https://travis-ci.org/KnpLabs/php-github-api)
[![StyleCI](https://styleci.io/repos/3948501/shield?style=flat)](https://styleci.io/repos/3948501)
[![Latest Stable Version](https://poser.pugx.org/knplabs/github-api/v/stable)](https://packagist.org/packages/knplabs/github-api)
[![Total Downloads](https://poser.pugx.org/knplabs/github-api/downloads)](https://packagist.org/packages/knplabs/github-api)
[![Latest Unstable Version](https://poser.pugx.org/knplabs/github-api/v/unstable)](https://packagist.org/packages/knplabs/github-api)
[![Monthly Downloads](https://poser.pugx.org/knplabs/github-api/d/monthly)](https://packagist.org/packages/knplabs/github-api)
[![Daily Downloads](https://poser.pugx.org/knplabs/github-api/d/daily)](https://packagist.org/packages/knplabs/github-api)

A simple Object Oriented wrapper for GitHub API, written with PHP.

Uses [GitHub API v3](http://developer.github.com/v3/) & supports [GitHub API v4](http://developer.github.com/v4). The object API (v3) is very similar to the RESTful API.

## Features

* Light and fast thanks to lazy loading of API classes
* Extensively tested and documented

## Requirements

* PHP >= 7.1
* A [HTTP client](https://packagist.org/providers/php-http/client-implementation)
* A [PSR-7 implementation](https://packagist.org/providers/psr/http-message-implementation)
* (optional) PHPUnit to run tests.

## Install

Via Composer:

```bash
$ composer require knplabs/github-api php-http/guzzle6-adapter "^2.0"
```

Why `php-http/guzzle6-adapter`? We are decoupled from any HTTP messaging client with help by [HTTPlug](http://httplug.io/). Read about clients in our [docs](doc/customize.md).


## Using Laravel?

[Laravel GitHub](https://github.com/GrahamCampbell/Laravel-GitHub) by [Graham Campbell](https://github.com/GrahamCampbell) might interest you.

## Basic usage of `php-github-api` client

```php
<?php

// This file is generated by Composer
require_once __DIR__ . '/vendor/autoload.php';

$client = new \Github\Client();
$repositories = $client->api('user')->repositories('ornicar');
```

From `$client` object, you can access to all GitHub.

## Cache usage

This example uses the PSR6 cache pool [redis-adapter](https://github.com/php-cache/redis-adapter). See http://www.php-cache.com/ for alternatives.

```php
<?php

// This file is generated by Composer
require_once __DIR__ . '/vendor/autoload.php';

use Cache\Adapter\Redis\RedisCachePool;

$client = new \Redis();
$client->connect('127.0.0.1', 6379);
// Create a PSR6 cache pool
$pool = new RedisCachePool($client);

$client = new \Github\Client();
$client->addCache($pool);

// Do some request

// Stop using cache
$client->removeCache();
```

Using cache, the client will get cached responses if resources haven't changed since last time,
**without** reaching the `X-Rate-Limit` [imposed by github](http://developer.github.com/v3/#rate-limiting).


## Documentation

See the [`doc` directory](doc/) for more detailed documentation.

## License

`php-github-api` is licensed under the MIT License - see the LICENSE file for details

## Maintainers

Please read [this post](https://knplabs.com/en/blog/news-for-our-foss-projects-maintenance) first.

This library is maintained by the following people (alphabetically sorted) :
- @acrobat
- @Nyholm

## Contributors

- Thanks to [Thibault Duplessis aka. ornicar](http://github.com/ornicar) for his first version of this library.
- Thanks to [Joseph Bielawski aka. stloyd](http://github.com/stloyd) for his contributions and support.
- Thanks to [noloh](http://github.com/noloh) for his contribution on the Object API.
- Thanks to [bshaffer](http://github.com/bshaffer) for his contribution on the Repo API.
- Thanks to [Rolf van de Krol](http://github.com/rolfvandekrol) for his countless contributions.
- Thanks to [Nicolas Pastorino](http://github.com/jeanvoye) for his contribution on the Pull Request API.
- Thanks to [Edoardo Rivello](http://github.com/erivello) for his contribution on the Gists API.
- Thanks to [Miguel Piedrafita](https://github.com/m1guelpf) for his contribution to the v4 & Apps API.

Thanks to GitHub for the high quality API and documentation.
