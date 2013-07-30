<?php

namespace Github\Tests\Mock;

class TestResponse
{
    protected $loopCount;

    protected $content;

    public function __construct( $loopCount, array $content = array() )
    {
        $this->loopCount = $loopCount;
        $this->content   = $content;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return array|null
     */
    public function getPagination()
    {
        if($this->loopCount){
            $returnArray = array(
                'next' => 'http://github.com/' . $this->loopCount
            );
        } else {
            $returnArray = array(
                'prev' => 'http://github.com/prev'
            );
        }

        $this->loopCount--;

        return $returnArray;
    }
}
