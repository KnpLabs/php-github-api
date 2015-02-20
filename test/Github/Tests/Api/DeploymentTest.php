<?php

namespace Github\Tests\Api;

class DeploymentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateDeployment()
    {
        /** @var \Github\Api\Deployment $api */
        $api = $this->getApiMock();
        $deploymentData = array("ref" => "fd6a5f9e5a430dddae8d6a8ea378f913d3a766f9");
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/deployments', $deploymentData);

        $api->create("KnpLabs", "php-github-api", $deploymentData);
    }

    protected function getApiClass()
    {
        return 'Github\Api\Deployment';
    }
}
