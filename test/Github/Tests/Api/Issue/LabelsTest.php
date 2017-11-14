<?php declare(strict_types=1);

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class LabelsTest extends TestCase
{
    public function shouldGetProjectLabels()
    {
        $expectedValue = [
            ['name' => 'l3l0repo'],
            ['name' => 'other'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/labels', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldGetAllIssueLabels()
    {
        $expectedValue = [['name' => 'label']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', '123'));
    }

    public function shouldCreateLabel()
    {
        $expectedValue = [['name' => 'label', 'color' => 'FFFFFF']];
        $data = ['name' => 'label'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/labels', $data + ['color' => 'FFFFFF'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldGetSingleLabel()
    {
        $expectedValue = [['name' => 'label1']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/labels/label1')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'label1'));
    }

    public function shouldCreateLabelWithColor()
    {
        $expectedValue = [['name' => 'label', 'color' => '111111']];
        $data = ['name' => 'label', 'color' => '111111'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/labels', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldDeleteLabel()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/labels/foo')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->deleteLabel('KnpLabs', 'php-github-api', 'foo'));
    }

    public function shouldUpdateLabel()
    {
        $expectedValue = [['name' => 'bar', 'color' => 'FFF']];
        $data = ['name' => 'bar', 'color' => 'FFF'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/labels/foo', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 'foo', 'bar', 'FFF'));
    }

    public function shouldRemoveLabel()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels/somename')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123, 'somename'));
    }

    public function shouldAddOneLabel()
    {
        $expectedValue = ['label' => 'somename'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels', ['labelname'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('KnpLabs', 'php-github-api', 123, 'labelname'));
    }

    public function shouldAddManyLabels()
    {
        $expectedValue = ['label' => 'somename'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels', ['labelname', 'labelname2'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('KnpLabs', 'php-github-api', 123, ['labelname', 'labelname2']));
    }

    public function shouldReplaceLabels()
    {
        $expectedValue = [['label' => 'somename']];
        $data = ['labels' => ['labelname']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->replace('KnpLabs', 'php-github-api', 123, $data));
    }

    public function shouldNotAddWhenDoNotHaveLabelsToAdd()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('post');

        $api->add('KnpLabs', 'php-github-api', 123, []);
    }

    public function shouldClearLabels()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/issues/123/labels')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->clear('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Issue\Labels::class;
    }
}
