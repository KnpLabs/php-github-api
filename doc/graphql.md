## GraphQL API
[Back to the navigation](README.md)

Wraps [GitHub v4 API (GraphQL API)](http://developer.github.com/v4/).

#### Execute a query

```php
$rateLimits = $client->api('graphql')->execute($query);
```

#### Authentication

To use [GitHub v4 API (GraphQL API)](http://developer.github.com/v4/) requests must [authenticated]((../security.md)).

```php
$client->authenticate($token, null, Github\Client::AUTH_ACCESS_TOKEN);

$result = $client->api('graphql')->execute($query);
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

$client->authenticate('<your-token>', null, Github\Client::AUTH_ACCESS_TOKEN);

$orgInfo = $client->api('graphql')->execute($query, $variables);
```
