<?php

namespace Github\Api;

/**
 * Markdown Rendering API
 *
 * @link   http://developer.github.com/v3/markdown/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Markdown extends Api
{
    /**
     * @param string $text
     * @param string $mode
     *
     * @return string
     */
    public function render($text, $mode = 'markdown')
    {
        if (!in_array($mode, array())) {
            $mode = 'markdown';
        }

        return $this->post('markdown', array(
            'text' => $text,
            'mode' => $mode
        ));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public function renderRaw($file)
    {
        return $this->post('markdown/raw', array(
            'file' => $file
        ));
    }
}
