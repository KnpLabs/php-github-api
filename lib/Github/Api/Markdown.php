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
    public function render(string $text, string $mode = 'markdown', string $context = null): string
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

    public function renderRaw(string $file): string
    {
        return $this->post('/markdown/raw', [
            'file' => $file
        ]);
    }
}
