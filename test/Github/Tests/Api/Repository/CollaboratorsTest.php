<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class CollaboratorsTest extends TestCase
{
    public function shouldGetAllRepositoryCollaborators()
    {
        $expectedValue = [['username' => 'l3l0']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/collaborators')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldCheckIfRepositoryCollaborator()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/collaborators/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->check('KnpLabs', 'php-github-api', 'l3l0'));
    }

    public function shouldAddRepositoryCollaborator()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/collaborators/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('KnpLabs', 'php-github-api', 'l3l0'));
    }

    public function shouldRemoveRepositoryCollaborator()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/collaborators/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'l3l0'));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Collaborators::class;
    }
}
