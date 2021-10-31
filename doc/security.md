## Authentication & Security
[Back to the navigation](README.md)

Most GitHub services do not require authentication, but some do. For example the methods that allow you to change
properties on Repositories and some others. Therefore this step is facultative.

### Authenticate

GitHub provides some different ways of authentication. This API implementation implements three of them which are
handled by one function:

```php
$client->authenticate($usernameOrToken, $password, $method);
```

`$usernameOrToken` is, of course, the username (or in some cases token/client ID, more details you can find below),
and guess what should contain `$password`. The `$method` can contain one of the three allowed values:

#### Supported methods
* `Github\AuthMethod::CLIENT_ID` - https://developer.github.com/v3/#oauth2-keysecret
* `Github\AuthMethod::ACCESS_TOKEN` - https://developer.github.com/v3/#oauth2-token-sent-in-a-header
* `Github\AuthMethod::JWT` - https://developer.github.com/apps/building-github-apps/authenticating-with-github-apps/#authenticating-as-a-github-app

The required value of `$password` depends on the chosen `$method`. For `Github\AuthMethod::CLIENT_ID`, `Github\AuthMethod::ACCESS_TOKEN` and
`Github\AuthMethod::JWT` methods you should provide the API token in `$usernameOrToken` variable (`$password` is omitted in
this particular case).

The `Github\AuthMethod::JWT` authentication method sends the specified JSON Web Token in an Authorization header.

After executing the `$client->authenticate($usernameOrToken, $secret, $method);` method using correct credentials, all
further requests are done as the given user.

### Authenticating as an Integration

To authenticate as an integration you need to supply a JSON Web Token with `Github\AuthMethod::JWT` to request
and installation access token which is then usable with `Github\AuthMethod::ACCESS_TOKEN`. [Github´s integration
authentication docs](https://developer.github.com/apps/building-github-apps/authentication-options-for-github-apps/#authenticating-as-a-github-app) describe the flow in detail.
It´s important for integration requests to use the custom Accept header `application/vnd.github.machine-man-preview`.

The following sample code authenticates as an installation using [lcobucci/jwt 4.1](https://github.com/lcobucci/jwt/tree/4.1.x)
to generate a JSON Web Token (JWT).

```php
use Github\HttpClient\Builder;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Rsa\Sha256;

$builder = new Builder();

$github = new Github\Client($builder, 'machine-man-preview');

$config = Configuration::forSymmetricSigner(
    new Sha256(),
    LocalFileReference::file('path/to/integration.private-key.pem')
);

$now = new \DateTimeImmutable();
$jwt = $config->builder(ChainedFormatter::withUnixTimestampDates())
    ->issuedBy($integrationId)
    ->issuedAt($now)
    ->expiresAt($now->modify('+1 minute'))
    ->getToken($config->signer(), $config->signingKey())
;

$github->authenticate($jwt->toString(), null, Github\AuthMethod::JWT)
```

The `$integrationId` you can find in the about section of your github app.
The `$installationId` you can find by installing the app and using the id in the url.
