# PHP GitHub API

[![Build Status](https://travis-ci.org/KnpLabs/php-github-api.svg?branch=master)](https://travis-ci.org/KnpLabs/php-github-api)
[![StyleCI](https://styleci.io/repos/3948501/shield?style=flat)](https://styleci.io/repos/3948501)

A simple Object Oriented wrapper for GitHub API, written with PHP5.

Uses [GitHub API v3](http://developer.github.com/v3/). The object API is very similar to the RESTful API.

## Features

* Follows PSR-0 conventions and coding standard: autoload friendly
* Light and fast thanks to lazy loading of API classes
* Extensively tested and documented

## Requirements

* PHP >= 5.3.2 with [cURL](http://php.net/manual/en/book.curl.php) extension,
* [Guzzle](https://github.com/guzzle/guzzle) library,
* (optional) PHPUnit to run tests.

## Autoload

The new version of `php-github-api` using [Composer](http://getcomposer.org).
The first step to use `php-github-api` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Then we have to install our dependencies using:
```bash
$ php composer.phar install
```
Now we can use autoloader from Composer by:
```bash
$ php composer.phar require knplabs/github-api
```

> `php-github-api` follows the PSR-0 convention names for its classes, which means you can easily integrate `php-github-api` classes loading in your own autoloader.

## Using Laravel?

[Laravel GitHub](https://github.com/GrahamCampbell/Laravel-GitHub) by [Graham Campbell](https://github.com/GrahamCampbell) might interest you.

## Basic usage of `php-github-api` client

```php
<?php

// This file is generated by Composer
require_once 'vendor/autoload.php';

$client = new \Github\Client();
$repositories = $client->api('user')->repositories('ornicar');
```

From `$client` object, you can access to all GitHub.

## Cache usage

```php
<?php

// This file is generated by Composer
require_once 'vendor/autoload.php';

$client = new \Github\Client(
    new \Github\HttpClient\CachedHttpClient(array('cache_dir' => '/tmp/github-api-cache'))
);

// Or select directly which cache you want to use
$client = new \Github\HttpClient\CachedHttpClient();
$client->setCache(
    // Built in one, or any cache implementing this interface:
    // Github\HttpClient\Cache\CacheInterface
    new \Github\HttpClient\Cache\FilesystemCache('/tmp/github-api-cache')
);

$client = new \Github\Client($client);
```

Using cache, the client will get cached responses if resources haven't changed since last time,
**without** reaching the `X-Rate-Limit` [imposed by github](http://developer.github.com/v3/#rate-limiting).


## Documentation

See the [`doc` directory](doc/) for more detailed documentation.

## License

`php-github-api` is licensed under the MIT License - see the LICENSE file for details

## Credits

### Sponsored by

[![KnpLabs Team](http://knplabs.com/front/images/knp-labs-logo.png)](http://knplabs.com)

### Contributors

- Thanks to [Thibault Duplessis aka. ornicar](http://github.com/ornicar) for his first version of this library.
- Thanks to [Joseph Bielawski aka. stloyd](http://github.com/stloyd) for his contributions and support.
- Thanks to [noloh](http://github.com/noloh) for his contribution on the Object API.
- Thanks to [bshaffer](http://github.com/bshaffer) for his contribution on the Repo API.
- Thanks to [Rolf van de Krol](http://github.com/rolfvandekrol) for his countless contributions.
- Thanks to [Nicolas Pastorino](http://github.com/jeanvoye) for his contribution on the Pull Request API.
- Thanks to [Edoardo Rivello](http://github.com/erivello) for his contribution on the Gists API.

Thanks to GitHub for the high quality API and documentation.
