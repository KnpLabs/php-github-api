<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ProtectionTest extends TestCase
{
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

    public function shouldShowStatusChecks()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showStatusChecks('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldUpdateStatusChecks()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->updateStatusChecks('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldRemoveStatusChecks()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeStatusChecks('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldShowStatusChecksContexts()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showStatusChecksContexts('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldReplaceStatusChecksContexts()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replaceStatusChecksContexts('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldAddStatusChecksContexts()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addStatusChecksContexts('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldRemoveStatusChecksContexts()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_status_checks/contexts')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeStatusChecksContexts('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldShowPullRequestReviewEnforcement()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_pull_request_reviews')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showPullRequestReviewEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldUpdatePullRequestReviewEnforcement()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_pull_request_reviews')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->updatePullRequestReviewEnforcement('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldRemovePullRequestReviewEnforcement()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/required_pull_request_reviews')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removePullRequestReviewEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldShowAdminEnforcement()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/enforce_admins')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showAdminEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldAddAdminEnforcement()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/enforce_admins')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addAdminEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldRemoveAdminEnforcement()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/enforce_admins')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeAdminEnforcement('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldShowRestrictions()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldRemoveRestrictions()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldShowTeamRestrictions()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showTeamRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldReplaceTeamRestrictions()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replaceTeamRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldAddTeamRestrictions()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addTeamRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldRemoveTeamRestrictions()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/teams')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->removeTeamRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldShowUserRestrictions()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showUserRestrictions('KnpLabs', 'php-github-api', 'master'));
    }

    public function shouldReplaceUserRestrictions()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replaceUserRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldAddUserRestrictions()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/branches/master/protection/restrictions/users')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->addUserRestrictions('KnpLabs', 'php-github-api', 'master', $data));
    }

    public function shouldRemoveUserRestrictions()
    {
        $expectedValue = array('someOutput');
        $data = array('someInput');

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
    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Protection::class;
    }
}
