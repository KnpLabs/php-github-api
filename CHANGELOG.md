# Change Log

The change log describes what is "Added", "Removed", "Changed" or "Fixed" between each release. 

## 2.6.0 (unreleased)

## 2.5.0

### Added

- Stable support for graphql api (V4) (#593)
- Stable support for apps (previously integrations) (#592)
- `Repo::events()`

### Fixed

- Incorrect link in repository search docs (#594)
- Added the required parameter `$message` on `Review::dismiss`.

## 2.4.0

### Added

- `Integrations::configure` to allow accessing early access program endpoints. 
- Add support for pagination and parameters in the pull request comments
- Add the ability to fetch user installations (`CurrentUser::installations`)
- Allow getting repo info by id (`Repo::showById`)
- Allow fetching repositories for a specific installation and user (`CurrentUser::repositoriesByInstallation`)

### Changed

- `PullRequest\Review` and `PullRequest\ReviewRequest` is now part of the official API. No need to call `configure`. 

## 2.3.0

### Fixed

- Issue where we serve the wrong cached response. We vary on authorization header now.

### Added

- `PullRequest::status`
- Throw InvalidArgumentException on `PullRequest::merge` when wrong merge method is used.
- Added `Protection::configure`

### Changed

- First argument to `Integrations::listRepositories()` is now optional. 
- Moved tests from "functional" to "integration"

## 2.2.0

### Added

- API support for Pull Request Review Requests.
- API support for Traffic. 
- API support for issue Assignees. 
- API support for Miscellaneous Gitignore and Emojis. 
- Added endpoints for issue lock, unlock and issue label show. 
- Added more parameters to `User::starred`.
- Fluid interface by allowing `configure()` to return `$this`.
- `configure()` support for issues API.

### Fixed

- Cache issue where some requests are not cached
- Issue with `User::all()` creates a query with double question marks.

## 2.1.0

### Added

- Add support for retrieving a single notification info using his ID 
- Add a function to get user organizations
- Added GraphQL support
- Add page variable to organization repo list (Organization::repositories())
- Add support for pull request review. 
- Add support for adding branch protection.

### Fixed

- Bug with double slashes when using enterprise URL. 
- Bug when headers not being passed to request (#529)

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
