## GraphQL API
[Back to the navigation](README.md)

Wraps [GitHub v4 API (GraphQL API)](http://developer.github.com/v4/).

#### Execute a query

```php
$rateLimits = $client->api('graphql')->execute($query);
```

#### Use variables

[Variables](https://developer.github.com/v4/guides/forming-calls/#working-with-variables) allow specifying of requested data without dynamical change of a query on a client side.

```php
$query = <<<'QUERY'
query showOrganizationInfo (
  $organizationLogin: String!
) {
  organization(login: $organizationLogin) {
    name
    url
  }
}
QUERY;
$variables = [
    'organizationLogin' => 'KnpLabs'
];

$orgInfo = $client->api('graphql')->execute($query, $variables);
```