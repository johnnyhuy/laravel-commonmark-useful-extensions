<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;
use JohnnyHuy\Laravel\Inline\Element\Gist;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class GistRenderer implements InlineRendererInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractInline|AbstractWebResource $inline
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     *
     * @return \League\CommonMark\HtmlElement|string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Gist)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $script = new HtmlElement('script', [
            'src' => $inline->getUrl().'.js'
        ]);

        return new HtmlElement('div', ['class' => 'gist-container'], $script);
    }

    /**
     * @param string $url
     * @return string
     */
    public function getContent(string $url) : string
    {
        return file_get_contents($url);
    }
}
