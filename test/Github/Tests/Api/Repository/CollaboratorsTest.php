<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class CollaboratorsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryCollaborators()
    {
        $expectedValue = array(array('username' => 'l3l0'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/collaborators')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCheckIfRepositoryCollaborator()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/collaborators/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->check('KnpLabs', 'php-github-api', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldAddRepositoryCollaborator()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('repos/KnpLabs/php-github-api/collaborators/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('KnpLabs', 'php-github-api', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryCollaborator()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/KnpLabs/php-github-api/collaborators/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'l3l0'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Collaborators';
    }
}
