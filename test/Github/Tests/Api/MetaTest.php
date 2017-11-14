<?php declare(strict_types=1);

namespace Github\Tests\Api;

class MetaTest extends TestCase
{
    public function shouldGetInformationService()
    {
        $expectedArray = array(
            'hooks' => array(
                '127.0.0.1/32'
            ),
            'git' => array(
                '127.0.0.1/32'
            ),
            'verifiable_password_authentication' => true
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->service());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Meta::class;
    }
}
