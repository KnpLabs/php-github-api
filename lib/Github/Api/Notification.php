<?php declare(strict_types=1);

namespace Github\Api;

use DateTime;

/**
 * API for accessing Notifications from your Git/Github repositories.
 *
 * Important! You have to be authenticated to perform these methods
 *
 * @link   https://developer.github.com/v3/activity/notifications/
 * @author Dennis de Greef <github@link0.net>
 */
class Notification extends AbstractApi
{
    /**
     * Get a listing of notifications.
     *
     * @link https://developer.github.com/v3/activity/notifications/
     *
     * @return array|null array of notifications
     */
    public function all(bool $includingRead = false, bool $participating = false, DateTime $since = null)
    {
        $parameters = [
            'all' => $includingRead,
            'participating' => $participating
        ];

        if ($since !== null) {
            $parameters['since'] = $since->format(DateTime::ISO8601);
        }

        return $this->get('/notifications', $parameters);
    }

    /**
     * Marks all notifications as read from the current date
     * Optionally give DateTime to mark as read before that date.
     *
     * @link https://developer.github.com/v3/activity/notifications/#mark-as-read
     */
    public function markRead(DateTime $since = null)
    {
        $parameters = [];

        if ($since !== null) {
            $parameters['last_read_at'] = $since->format(DateTime::ISO8601);
        }

        $this->put('/notifications', $parameters);
    }
    /**
     * Gets a single notification using his ID
     *
     * @link https://developer.github.com/v3/activity/notifications/#view-a-single-thread
     */
    public function id(int $id)
    {
        return $this->get('/notifications/threads/'.$id);
    }
}
