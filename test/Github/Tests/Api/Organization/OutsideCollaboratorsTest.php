<?php

declare(strict_types=1);

namespace Github\Tests\Api\Organization;

use Github\Tests\Api\TestCase;

class OutsideCollaboratorsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryProjects()
    {
        $expectedValue = [['login' => 'KnpLabs']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/outside_collaborators')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldConvertAnOrganizationMemberToOutsideCollaborator()
    {
        $expectedValue = 'expectedResponse';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/orgs/KnpLabs/outside_collaborators/username')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->convert('KnpLabs', 'username'));
    }

    /**
     * @test
     */
    public function shouldRemoveAnOutsideCollaboratorFromAnOrganization()
    {
        $expectedValue = 'expectedResponse';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/outside_collaborators/username')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'username'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Organization\OutsideCollaborators::class;
    }
}
