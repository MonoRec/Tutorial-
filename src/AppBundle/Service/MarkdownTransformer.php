<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/8/2017
 * Time: 17:19
 */

namespace AppBundle\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownTransformer
{

    private $markdownParser;

    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse($str) {

        return $this->markdownParser->transformMarkdown($str);

    }

}