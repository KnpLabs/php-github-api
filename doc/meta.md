## Meta API
[Back to the navigation](README.md)


Wrap [GitHub Meta API](https://docs.github.com/rest/meta/meta).

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
