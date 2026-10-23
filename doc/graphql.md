## GraphQL API
[Back to the navigation](README.md)

Wraps [GitHub GraphQL API](https://docs.github.com/graphql).

#### Execute a query

```php
$rateLimits = $client->api('graphql')->execute($query);
```

#### Authentication

To use [GitHub GraphQL API](https://docs.github.com/graphql) requests must [authenticate](security.md).

```php
$client->authenticate($token, null, Github\AuthMethod::ACCESS_TOKEN);

$result = $client->api('graphql')->execute($query);
```

#### Use different `Accept` Headers
You can preview upcoming features and changes to the GitHub GraphQL schema before they are added to the GitHub GraphQL API.
To access a schema preview, you'll need to provide a custom media type in the Accept header for your requests. Feature documentation for each preview specifies which custom media type to provide. More info about [Schema Previews](https://docs.github.com/graphql/overview/schema-previews).

To use [GitHub GraphQL API](https://docs.github.com/graphql) with different `Accept` header you can pass third argument to execute method.

```php
$result = $client->api('graphql')->execute($query, [], 'application/vnd.github.starfox-preview+json')
```
> default accept header is `application/vnd.github.v4+json`



#### Use variables

[Variables](https://docs.github.com/graphql/guides/forming-calls-with-graphql#working-with-variables) allow specifying of requested data without dynamical change of a query on a client side.

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

$client->authenticate('<your-token>', null, Github\AuthMethod::ACCESS_TOKEN);

$orgInfo = $client->api('graphql')->execute($query, $variables);
```
