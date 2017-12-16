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
        $expectedValue = ['required_status_checks', 'required_pull_reqeust_reviews', 'restrictions'];

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
        $expectedValue = ['required_status_checks', 'required_pull_reqeust_reviews', 'restrictions'];
        $data = ['required_status_checks' => null];

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
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldShowStatusChecks()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showStatusChecks('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldUpdateStatusChecks()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->updateStatusChecks('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldRemoveStatusChecks()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeStatusChecks('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldShowStatusChecksContexts()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showStatusChecksContexts('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldReplaceStatusChecksContexts()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replaceStatusChecksContexts('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldAddStatusChecksContexts()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addStatusChecksContexts('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldRemoveStatusChecksContexts()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeStatusChecksContexts('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldShowPullRequestReviewEnforcement()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_pull_request_reviews')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showPullRequestReviewEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldUpdatePullRequestReviewEnforcement()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_pull_request_reviews')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->updatePullRequestReviewEnforcement('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldRemovePullRequestReviewEnforcement()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_pull_request_reviews')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removePullRequestReviewEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldShowAdminEnforcement()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/enforce_admins')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showAdminEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldAddAdminEnforcement()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/enforce_admins')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addAdminEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldRemoveAdminEnforcement()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/enforce_admins')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeAdminEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldShowRestrictions()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldRemoveRestrictions()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldShowTeamRestrictions()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showTeamRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldReplaceTeamRestrictions()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replaceTeamRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldAddTeamRestrictions()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addTeamRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldRemoveTeamRestrictions()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeTeamRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldShowUserRestrictions()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showUserRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldReplaceUserRestrictions()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replaceUserRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldAddUserRestrictions()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addUserRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @test
     */
    public function shouldRemoveUserRestrictions()
    {
        $expectedValue = ['someOutput'];
        $data = ['someInput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeUserRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Protection::class;
    }
}
