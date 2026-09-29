## CodeOfConduct API
[Back to the navigation](../README.md)

Wraps [GitHub Codes of conduct API](https://docs.github.com/rest/codes-of-conduct/codes-of-conduct).

### Lists all code of conducts.

```php
$codeOfConducts = $client->api('codeOfConduct')->all();
```

### Get a code of conduct.

```php
$codeOfConducts = $client->api('codeOfConduct')->show('contributor_covenant');
```
