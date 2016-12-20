## Notification API
[Back to the navigation](README.md)

Listing notifications and marking them as read.
Wraps [GitHub Notification API](https://developer.github.com/v3/activity/notifications/).

### List notifications

```php
$issues = $client->api('notification')->all();
```

Returns an array of unread notifications.

### Include already read notifications, including participating, or since a certain date

```php
$includingRead = true;
$participating = true;
$since = new DateTime('1970/01/01');
$issues = $client->api('notification')->all($includingRead, $participating, $since);
```

Returns an array of all notifications

### Mark notifications as read

```php
$client->api('notification')->markRead();
```

or up until a certain date

```php
$client->api('notification')->markRead(new DateTime('2015/01/01'));
```

Marks all notifications as read up until the current date, unless a date is given

## Get a single notification using his ID

```php
$client->api('notification')->id($id);
```
Retrieves single notification data using his ID.
