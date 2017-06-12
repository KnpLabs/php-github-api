<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ProtectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowProtection()
    {
        $expectedValue = array('required_status_checks', 'required_pull_reqeust_reviews', 'restrictions');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldUpdateProtection()
    {
        $expectedValue = array('required_status_checks', 'required_pull_reqeust_reviews', 'restrictions');
        $data = array('required_status_checks' => null);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldRemoveProtection()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Protection::class;
    }
}
