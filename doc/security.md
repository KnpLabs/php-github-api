## Authentication & Security
[Back to the navigation](README.md)

Most GitHub services do not require authentication, but some do. For example the methods that allow you to change
properties on Repositories and some others. Therefore this step is facultative.

### Authenticate

GitHub provides some different ways of authentication. This API implementation implements three of them which are handled by one function:

```php
$client->authenticate($usernameOrToken, $password, $method);
```

`$usernameOrToken` is, of course, the username (or in some cases token/client ID, more details you can find below),
and guess what should contain `$password`. The `$method` can contain one of the five allowed values:

#### Deprecated methods
* `Github\Client::AUTH_URL_TOKEN` use `Github\Client::AUTH_ACCESS_TOKEN` instead.
* `Github\Client::AUTH_URL_CLIENT_ID` use `Github\Client::AUTH_CLIENT_ID` instead.
* `Github\Client::AUTH_HTTP_TOKEN` use `Github\Client::AUTH_ACCESS_TOKEN` instead.
* `Github\Client::AUTH_HTTP_PASSWORD` use `Github\Client::AUTH_ACCESS_TOKEN` instead.

#### Supported methods
* `Github\Client::AUTH_CLIENT_ID` - https://developer.github.com/v3/#oauth2-keysecret
* `Github\Client::AUTH_ACCESS_TOKEN` - https://developer.github.com/v3/#oauth2-token-sent-in-a-header
* `Github\Client::AUTH_JWT` - https://developer.github.com/apps/building-github-apps/authenticating-with-github-apps/#authenticating-as-a-github-app

The required value of `$password` depends on the chosen `$method`. For `Github\Client::AUTH_URL_TOKEN`,
`Github\Client::AUTH_HTTP_TOKEN`, `Github\Client::AUTH_ACCESS_TOKEN` and `Github\Client::JWT` methods you should provide the API token in
`$usernameOrToken` variable (`$password` is omitted in this particular case). For the
`Github\Client::AUTH_HTTP_PASSWORD`, you should provide the password of the account. When using `Github\Client::AUTH_URL_CLIENT_ID`
`$usernameOrToken` should contain your client ID, and `$password` should contain client secret.

After executing the `$client->authenticate($usernameOrToken, $secret, $method);` method using correct credentials,
all further requests are done as the given user.

### About authentication methods

The `Github\Client::AUTH_URL_TOKEN` authentication method sends the API token in URL parameters.
The `Github\Client::AUTH_URL_CLIENT_ID` authentication method sends the client ID and secret in URL parameters.
The `Github\Client::AUTH_HTTP_*` authentication methods send their values to GitHub using HTTP Basic Authentication.
The `Github\Client::AUTH_JWT` authentication method sends the specified JSON Web Token in an Authorization header.

`Github\Client::AUTH_URL_TOKEN` used to be the only available authentication method. To prevent existing applications
from changing their behavior in case of an API upgrade, this method is chosen as the default for this API implementation.

Note however that GitHub describes this method as deprecated. In most case you should use the
`Github\Client::AUTH_HTTP_TOKEN` instead.

### Authenticating as an Integration

To authenticate as an integration you need to supply a JSON Web Token with `Github\Client::AUTH_JWT` to request
and installation access token which is then usable with `Github\Client::AUTH_ACCESS_TOKEN`. [Github´s integration
authentication docs](https://developer.github.com/apps/building-github-apps/authentication-options-for-github-apps/#authenticating-as-a-github-app) describe the flow in detail.
It´s important for integration requests to use the custom Accept header `application/vnd.github.machine-man-preview`.

The following sample code authenticates as an installation using [lcobucci/jwt 3.4](https://github.com/lcobucci/jwt/tree/3.4)
to generate a JSON Web Token (JWT).

```php
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Rsa\Sha256;

$github = new Github\Client($builder, 'machine-man-preview');

$config = Configuration::forSymmetricSigner(
    new Sha256(),
    LocalFileReference::file('path/to/integration.private-key.pem')
);

$now = new \DateTimeImmutable();
$jwt = $config->builder()
    ->issuedBy($integrationId)
    ->issuedAt($now)
    ->expiresAt($now->modify('+1 minute'))
    ->getToken($config->signer(), $config->signingKey())
;

$github->authenticate($jwt, null, Github\Client::AUTH_JWT)
```

The `$integrationId` you can find in the about section of your github app.
The `$installationId` you can find by installing the app and using the id in the url.
