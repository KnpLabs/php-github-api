<?php declare(strict_types=1);

namespace Github\Api;

/**
 * Markdown Rendering API.
 *
 * @link   http://developer.github.com/v3/markdown/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Markdown extends AbstractApi
{
    /**
     * @return string|null
     */
    public function render(string $text, string $mode = 'markdown', string $context = null)
    {
        if (!in_array($mode, ['gfm', 'markdown'])) {
            $mode = 'markdown';
        }

        $params = [
            'text' => $text,
            'mode' => $mode
        ];
        if (null !== $context && 'gfm' === $mode) {
            $params['context'] = $context;
        }

        return $this->post('/markdown', $params);
    }

    /**
     * @return string|null
     */
    public function renderRaw(string $file)
    {
        return $this->post('/markdown/raw', [
            'file' => $file
        ]);
    }
}
