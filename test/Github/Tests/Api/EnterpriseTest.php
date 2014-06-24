<?php
/**
 * This file is part of the PHP GitHub API package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Github\Tests\Api;

class EnterpriseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetEntepriseStatsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Enterprise\Stats', $api->stats());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseLicenseApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Enterprise\License', $api->license());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Enterprise';
    }
}
 