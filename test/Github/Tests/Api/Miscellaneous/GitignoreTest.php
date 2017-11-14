<?php declare(strict_types=1);

namespace Github\Tests\Api\Miscellaneous;

use Github\Api\Miscellaneous\Emojis;
use Github\Api\Miscellaneous\Gitignore;
use Github\Tests\Api\TestCase;

class GitignoreTest extends TestCase
{
    public function shouldGetAllTemplates()
    {
        $expectedArray = array(
            'Actionscript',
            'Android',
            'AppceleratorTitanium',
            'Autotools',
            'Bancha',
            'C',
            'C++'
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gitignore/templates')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    public function shouldGetTemplate()
    {
        $expectedArray = array(
            'name' => 'C',
            'source' => "# Object files\n*.o\n\n# Libraries\n*.lib\n*.a"
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/gitignore/templates/C')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('C'));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Gitignore::class;
    }
}
