<?php declare(strict_types=1);

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/activity/notifications/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Notifications extends AbstractApi
{
    /**
     * List all notifications for the authenticated user.
     *
     * @link http://developer.github.com/v3/activity/notifications/#list-your-notifications
     */
    public function all(array $params = []): array
    {
        return $this->get('/notifications', $params);
    }

    /**
     * List all notifications for the authenticated user in selected repository.
     *
     * @link http://developer.github.com/v3/activity/notifications/#list-your-notifications-in-a-repository
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     */
    public function allInRepository(string $username, string $repository, array $params = []): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/notifications', $params);
    }

    /**
     * Mark all notifications as read.
     *
     * @link http://developer.github.com/v3/activity/notifications/#mark-as-read
     */
    public function markAsReadAll(array $params = []): array
    {
        return $this->put('/notifications', $params);
    }

    /**
     * Mark all notifications for a repository as read.
     *
     * @link http://developer.github.com/v3/activity/notifications/#mark-notifications-as-read-in-a-repository
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     */
    public function markAsReadInRepository(string $username, string $repository, array $params = []): array
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/notifications', $params);
    }

    /**
     * Mark a notification as read.
     *
     * @link http://developer.github.com/v3/activity/notifications/#mark-a-thread-as-read
     *
     * @param int   $id     the notification number
     */
    public function markAsRead(int $id, array $params): array
    {
        return $this->patch('/notifications/threads/'.rawurlencode($id), $params);
    }

    /**
     * Show a notification.
     *
     * @link http://developer.github.com/v3/activity/notifications/#view-a-single-thread
     *
     * @param int $id the notification number
     */
    public function show(int $id): array
    {
        return $this->get('/notifications/threads/'.rawurlencode($id));
    }

    /**
     * Show a subscription.
     *
     * @link http://developer.github.com/v3/activity/notifications/#get-a-thread-subscription
     *
     * @param int $id the notification number
     */
    public function showSubscription(int $id): array
    {
        return $this->get('/notifications/threads/'.rawurlencode($id).'/subscription');
    }

    /**
     * Create a subscription.
     *
     * @link http://developer.github.com/v3/activity/notifications/#set-a-thread-subscription
     *
     * @param int   $id     the notification number
     */
    public function createSubscription(int $id, array $params): array
    {
        return $this->put('/notifications/threads/'.rawurlencode($id).'/subscription', $params);
    }

    /**
     * Delete a subscription.
     *
     * @link http://developer.github.com/v3/activity/notifications/#delete-a-thread-subscription
     *
     * @param int $id the notification number
     */
    public function removeSubscription(int $id): array
    {
        return $this->delete('/notifications/threads/'.rawurlencode($id).'/subscription');
    }
}
