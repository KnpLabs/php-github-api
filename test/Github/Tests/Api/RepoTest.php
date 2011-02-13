<?php

class Github_Tests_Api_RepoTest extends Github_Tests_ApiTest
{
    public function testSearch()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('get')
            ->with('repos/search/github+api', array(
                'language' => 'fr',
                'start_page' => 3
            ));

        $api->search('github api', 'fr', 3);
    }

    protected function getApiClass()
    {
        return 'Github_Api_Repo';
    }
}
