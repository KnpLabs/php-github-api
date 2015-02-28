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
        $parameters = array(
            'all' => false,
            'participating' => false,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('notifications', $parameters);

        $api->all();
    }

    /**
     * @test
     */
    public function shouldGetNotificationsSince()
    {
        $since = new DateTime('now');

        $parameters = array(
            'all' => false,
            'participating' => false,
            'since' => $since->format(DateTime::ISO8601),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('notifications', $parameters);

        $api->all(false, false, $since);
    }

    /**
     * @test
     */
    public function shouldGetNotificationsIncludingAndParticipating()
    {
        $parameters = array(
            'all' => true,
            'participating' => true,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('notifications', $parameters);

        $api->all(true, true);
    }

    /**
     * @test
     */
    public function shouldMarkNotificationsAsRead()
    {
        $parameters = array();

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('notifications', $parameters);

        $api->markRead();
    }

    /**
     * @test
     */
    public function shouldMarkNotificationsAsReadForGivenDate()
    {
        $since = new DateTime('now');

        $parameters = array(
            'last_read_at' => $since->format(DateTime::ISO8601),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('notifications', $parameters);

        $api->markRead($since);
    }

    protected function getApiClass()
    {
        return 'Github\Api\Notification';
    }
}
