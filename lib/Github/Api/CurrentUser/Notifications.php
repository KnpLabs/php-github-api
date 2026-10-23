<?php

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/activity/notifications
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Notifications extends AbstractApi
{
    /**
     * List all notifications for the authenticated user.
     *
     * @link https://docs.github.com/rest/activity/notifications#list-notifications-for-the-authenticated-user
     *
     * @param array $params
     *
     * @return array
     */
    public function all(array $params = [])
    {
        return $this->get('/notifications', $params);
    }

    /**
     * List all notifications for the authenticated user in selected repository.
     *
     * @link https://docs.github.com/rest/activity/notifications#list-repository-notifications-for-the-authenticated-user
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param array  $params
     *
     * @return array
     */
    public function allInRepository($username, $repository, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/notifications', $params);
    }

    /**
     * Mark all notifications as read.
     *
     * @link https://docs.github.com/rest/activity/notifications#mark-notifications-as-read
     *
     * @param array $params
     *
     * @return array
     */
    public function markAsReadAll(array $params = [])
    {
        return $this->put('/notifications', $params);
    }

    /**
     * Mark all notifications for a repository as read.
     *
     * @link https://docs.github.com/rest/activity/notifications#mark-repository-notifications-as-read
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param array  $params
     *
     * @return array
     */
    public function markAsReadInRepository($username, $repository, array $params = [])
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/notifications', $params);
    }

    /**
     * Mark a notification as read.
     *
     * @link https://docs.github.com/rest/activity/notifications#mark-a-thread-as-read
     *
     * @param int   $id     the notification number
     * @param array $params
     *
     * @return array
     */
    public function markAsRead($id, array $params)
    {
        return $this->patch('/notifications/threads/'.$id, $params);
    }

    /**
     * Show a notification.
     *
     * @link https://docs.github.com/rest/activity/notifications#get-a-thread
     *
     * @param int $id the notification number
     *
     * @return array
     */
    public function show($id)
    {
        return $this->get('/notifications/threads/'.$id);
    }

    /**
     * Show a subscription.
     *
     * @link https://docs.github.com/rest/activity/notifications#get-a-thread-subscription-for-the-authenticated-user
     *
     * @param int $id the notification number
     *
     * @return array
     */
    public function showSubscription($id)
    {
        return $this->get('/notifications/threads/'.$id.'/subscription');
    }

    /**
     * Create a subscription.
     *
     * @link https://docs.github.com/rest/activity/notifications#set-a-thread-subscription
     *
     * @param int   $id     the notification number
     * @param array $params
     *
     * @return array
     */
    public function createSubscription($id, array $params)
    {
        return $this->put('/notifications/threads/'.$id.'/subscription', $params);
    }

    /**
     * Delete a subscription.
     *
     * @link https://docs.github.com/rest/activity/notifications#delete-a-thread-subscription
     *
     * @param int $id the notification number
     *
     * @return array
     */
    public function removeSubscription($id)
    {
        return $this->delete('/notifications/threads/'.$id.'/subscription');
    }
}
