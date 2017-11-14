<?php declare(strict_types=1);

namespace Github\Tests\Api;

class DeploymentTest extends TestCase
{
    public function shouldCreateDeployment()
    {
        $api = $this->getApiMock();
        $deploymentData = ['ref' => 'fd6a5f9e5a430dddae8d6a8ea378f913d3a766f9'];
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/deployments', $deploymentData);

        $api->create('KnpLabs', 'php-github-api', $deploymentData);
    }

    public function shouldGetAllDeployments()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/deployments');

        $api->all('KnpLabs', 'php-github-api');
    }

    public function shouldGetAllDeploymentsWithFilterParameters()
    {
        $api = $this->getApiMock();
        $filterData = ['foo' => 'bar', 'bar' => 'foo'];

        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/deployments', $filterData);

        $api->all('KnpLabs', 'php-github-api', $filterData);
    }

    public function shouldShowProject()
    {
        $expectedValue = ['id' => 123, 'ref' => 'master'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/deployments/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    public function shouldCreateStatusUpdate()
    {
        $api = $this->getApiMock();
        $statusData = ['state' => 'pending', 'description' => 'waiting to start'];

        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/deployments/1/statuses', $statusData);

        $api->updateStatus('KnpLabs', 'php-github-api', 1, $statusData);
    }

    public function shouldRejectStatusUpdateWithoutStateField()
    {
        $api = $this->getApiMock();
        $statusData = ['description' => 'waiting to start'];

        $api->updateStatus('KnpLabs', 'php-github-api', 1, $statusData);
    }

    public function shouldGetAllStatuses()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/deployments/1/statuses');

        $api->getStatuses('KnpLabs', 'php-github-api', 1);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Deployment::class;
    }
}
