<?php

namespace Github\Tests\Api;

use DateTime;

class NotificationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetNotifications()
    {
        $parameters = [
            'all' => false,
            'participating' => false,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/notifications', $parameters);

        $api->all();
    }

    /**
     * @test
     */
    public function shouldGetNotificationsSince()
    {
        $since = new DateTime('now');

        $parameters = [
            'all' => false,
            'participating' => false,
            'since' => $since->format(DateTime::ISO8601),
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/notifications', $parameters);

        $api->all(false, false, $since);
    }

    /**
     * @test
     */
    public function shouldGetNotificationsBefore()
    {
        $before = new DateTime('now');

        $parameters = [
            'all' => false,
            'participating' => false,
            'before' => $before->format(DateTime::ISO8601),
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/notifications', $parameters);

        $api->all(false, false, null, $before);
    }

    /**
     * @test
     */
    public function shouldGetNotificationsIncludingAndParticipating()
    {
        $parameters = [
            'all' => true,
            'participating' => true,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/notifications', $parameters);

        $api->all(true, true);
    }

    /**
     * @test
     */
    public function shouldMarkNotificationsAsRead()
    {
        $parameters = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/notifications', $parameters);

        $api->markRead();
    }

    /**
     * @test
     */
    public function shouldMarkNotificationsAsReadForGivenDate()
    {
        $since = new DateTime('now');

        $parameters = [
            'last_read_at' => $since->format(DateTime::ISO8601),
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/notifications', $parameters);

        $api->markRead($since);
    }

    /**
     * @test
     */
    public function shouldMarkThreadAsRead()
    {
        $id = mt_rand(1, time());
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/notifications/threads/'.$id);

        $api->markThreadRead($id);
    }

    public function shouldGetNotification()
    {
        $id = mt_rand(1, time());
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/notification/'.$id);

        $api->id($id);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Notification::class;
    }
}
