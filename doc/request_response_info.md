## Request / Response information
[Back to the navigation](README.md)

### Get response headers

Get the repsonse header for the latest request

```
$headers = $githubClient->getLastResponse()->getHeaders();
//Example headers
$headers['X-RateLimit-Remaining'];
$headers['X-OAuth-Scopes'];
$headers['X-Accepted-OAuth-Scopes'];
```
