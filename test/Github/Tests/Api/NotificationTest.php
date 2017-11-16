<?php declare(strict_types=1);

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

    public function shouldGetNotification()
    {
        $id = random_int(1, time());
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/notification/'.$id);

        $api->id($id);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Notification::class;
    }
}
