## CodeOfConduct API
[Back to the navigation](../README.md)

### Lists all code of conducts.

```php
$codeOfConducts = $client->api('codeOfConduct')->all();
```

### Get a code of conduct.

```php
$codeOfConducts = $client->api('codeOfConduct')->show('contributor_covenant');
```
