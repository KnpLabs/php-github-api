## Authentication & Security
[Back to the navigation](index.md)

Most GitHub services do not require authentication, but some do. For example the methods that allow you to change
properties on Repositories and some others. Therefore this step is facultative.

### Authenticate

GitHub provides some different ways of authentication. This API implementation implements three of them which are handled by one function:

```php
$client->authenticate($usernameOrToken, $password, $method);
```

`$usernameOrToken` is, of course, the username (or in some cases token/client ID, more details you can find below),
and guess what should contain `$password`. The `$method` can contain one of the three allowed values:

* `Github\Client::AUTH_URL_TOKEN`
* `Github\Client::AUTH_URL_CLIENT_ID`
* `Github\Client::AUTH_HTTP_TOKEN`
* `Github\Client::AUTH_HTTP_PASSWORD`

The required value of `$password` depends on the chosen `$method`. For the `Github\Client::AUTH_*_TOKEN` methods,
you should provide the API token in `$username` variable (`$password` is omitted in this particular case). For the
`Github\Client::AUTH_HTTP_PASSWORD`, you should provide the password of the account. When using `Github\Client::AUTH_URL_CLIENT_ID`
`$usernameOrToken` should contain your client ID, and `$password` should contain client secret.

After executing the `$client->authenticate($usernameOrToken, $secret, $method);` method using correct credentials,
all further requests are done as the given user.

### About authentication methods

The `Github\Client::AUTH_URL_TOKEN` authentication method sends the API token in URL parameters.
The `Github\Client::AUTH_URL_CLIENT_ID` authentication method sends the client ID and secret in URL parameters.
The `Github_Client::AUTH_HTTP_*` authentication methods send their values to GitHub using HTTP Basic Authentication.

`Github\Client::AUTH_URL_TOKEN` used to be the only available authentication method. To prevent existing applications
from changing their behavior in case of an API upgrade, this method is chosen as the default for this API implementation.

Note however that GitHub describes this method as deprecated. In most case you should use the
`Github\Client::AUTH_HTTP_TOKEN` instead.
