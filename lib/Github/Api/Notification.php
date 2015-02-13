<?php

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
     * Get a listing of a notifications
     * @link https://developer.github.com/v3/activity/notifications/
     *
     * @param bool $includingRead
     * @param bool $participating
     * @param null $since
     *
     * @return array array of notifications
     */
    public function all($includingRead = false, $participating = false, $since = null)
    {
        $parameters = array(
            'all' => $includingRead,
            'participating' => $participating
        );

        if($since !== null) {
            $parameters['since'] = $since;
        }

        return $this->get('notifications', $parameters);
    }

    /**
     * Marks all notifications as read from the current date
     * Optionally give DateTimeInterface to mark as read before that date
     *
     * @link https://developer.github.com/v3/activity/notifications/#mark-as-read
     *
     * @param \DateTime $since
     */
    public function markRead(DateTime $since = null)
    {
        $parameters = array();

        if($since !== null) {
            $parameters['last_read_at'] = $since->format(DateTime::ISO8601);
        }

        $this->put('notifications', $parameters);
    }
}
