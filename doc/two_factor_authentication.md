## Two factor authentication
[Back to the navigation](README.md)


### Raising the exception

```php
try {
    $authorization = $github->api('authorizations')->create();
} catch (Github\Exception\TwoFactorAuthenticationRequiredException $e) {
    echo sprintf("Two factor authentication of type %s is required.", $e->getType());
}
```

Once the code has been retrieved (by sms for example), you can create an authorization:

```
$authorization = $github->api('authorizations')->create(array('note' => 'Optional'), $code);
```
