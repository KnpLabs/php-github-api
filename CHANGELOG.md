# Change Log

The change log describes what is "Added", "Removed", "Changed" or "Fixed" between each release. 

## 2.0.2

### Fixed

- Bug with double slashes when using enterprise URL. 

## 2.0.0

### Added 

- Support for JWT authentication
- API for Organization\Members
- API for Integrations
- API for Repo\Cards
- API for Repo\Columns
- API for Repo\Projects
- API for User\MyRepositories
- Methods in Repo API for frequency and participation

### Changed

- `ApiLimitExceedException::__construct` has a new second parameter for the remaining API calls. 
- First parameter of `Github\Client` has changed type from `\Http\Client\HttpClient` to 
`Github\HttpClient\Builder`. A factory class was also added. To upgrade you need to change: 
 
```php
// Old way does not work:
$github = new Github\Client($httpClient); 

// New way will work:
$github = new Github\Client(new Github\HttpClient\Builder($httpClient)); 
$github = Github\Client::createWithHttpClient($httpClient);  
```
- Renamed the currentuser `DeployKeys` api class to `PublicKeys` to reflect to github api name. 

## 2.0.0-rc4

### Added 

- HTTPlug to decouple from Guzzle
- `Github\Client::getLastResponse` was added 
- Support for PSR-6 cache
- `Github\Client::addPlugin` and `Github\Client::removePlugin`
- `Github\Client::getApiVersion`
- `Github\Client::removeCache`

### Changed

- Uses of `Github\HttpClient\HttpClientInterface` is replaced by `Http\Client\HttpClient` ie the constructor of `Github\Client`.
- We use PSR-7's representation of HTTP message instead of `Guzzle\Http\Message\Response` and `Guzzle\Http\Message\Request`.
- `Github\Client::addHeaders` was added instead of `Github\Client::setHeaders`
- Signature of `Github\Client::useCache` has changed. First argument must be a `CacheItemPoolInterface`
- We use PSR-4 instead of PSR-0

### Removed

- Support for PHP 5.3 and 5.4
- `Github/HttpClient/HttpClientInterface` was removed
- `Github/HttpClient/HttpClient` was removed
-  All classes in `Github/HttpClient/HttpClient/Listener/*` were removed
- `Github/HttpClient/CachedHttpClient` was removed
-  All classes in `Github/HttpClient/Cache/*` were removed

## 1.7.1 

No change log before this version
