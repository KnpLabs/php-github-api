<?php declare(strict_types=1);

namespace Github\Tests\Api;

class CommitsTest extends TestCase
{
    public function shouldShowCommitUsingSha()
    {
        $expectedValue = array('sha' => '123', 'comitter');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/commits/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    public function shouldCreateCommit()
    {
        $expectedValue = array('sha' => '123', 'comitter');
        $data = array('message' => 'some message', 'tree' => 1234, 'parents' => array());

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/commits', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldNotCreateCommitWithoutMessageParam()
    {
        $data = array('tree' => 1234, 'parents' => array());

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateCommitWithoutTreeParam()
    {
        $data = array('message' => 'some message', 'parents' => array());

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateCommitWithoutParentsParam()
    {
        $data = array('message' => 'some message', 'tree' => '12334');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\GitData\Commits::class;
    }
}
