## Users API
[Back to the navigation](index.md)


Wrap [GitHub User API](http://developer.github.com/v3/meta/).

### Get information about GitHub services

```php
$service = $client->api('meta')->service();
```

return

```
array(3) {
  'verifiable_password_authentication' => bool
  'hooks' =>
  array(1) {
    [0] =>
    string(15) "127.0.0.1/22"
  }
  'git' =>
  array(1) {
    [0] =>
    string(15) "127.0.0.1/22"
  }
}
```