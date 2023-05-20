<?php

declare(strict_types=1);

namespace App\Content\Parser;

use App\Content\Model\Article;
use App\Core\Content\Parser\MarkdownParser;

final class ArticleParser extends MarkdownParser
{
    public function __construct()
    {
        parent::__construct(Article::class);
    }
}
