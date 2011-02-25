<?php

class Github_Tests_Functional_ObjectTest extends PHPUnit_Framework_TestCase
{
    public function testGetRawData()
    {
        $username = 'ornicar';
        $repo     = 'php-github-api';
        $sha1     = 'ab9f17c8ed85c0dd9f33ba8d2d61ebb570768158';

        $github = new Github_Client();
        $data = $github->getObjectApi()->getRawData($username, $repo, $sha1);

        $this->assertRegexp('/Release version 3\.1/', $data);
    }
}
