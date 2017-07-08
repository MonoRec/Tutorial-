<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/8/2017
 * Time: 18:28
 */

namespace AppBundle\Twig;


use AppBundle\Service\MarkdownTransformer;

class MarkdownExtension extends \Twig_Extension
{

    private $markdownTransformer;

    public function __construct(MarkdownTransformer $markdownTransformer)
    {
        $this->markdownTransformer = $markdownTransformer;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdownify', array($this, 'parseMarkdown'), [
                'is_safe' => ['html']
            ])
        ];
    }

    public function parseMarkdown($str) {
        return $this->markdownTransformer->parse($str);
    }

    public function getName() {
        return 'app_markdown';
    }

}