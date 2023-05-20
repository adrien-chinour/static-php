<?php

declare(strict_types=1);

namespace App\Content\Repository;

use App\Content\ContentType;
use App\Content\Parser\ArticleParser;
use App\Core\Content\Accessor\ContentAccessorInterface;
use App\Core\Content\Repository\AbstractContentRepository;

/**
 * @extends AbstractContentRepository<Article>
 */
final class ArticleRepository extends AbstractContentRepository
{
    public function __construct(ArticleParser $parser, ContentAccessorInterface $accessor)
    {
        parent::__construct(ContentType::ARTICLE, $parser, $accessor);
    }

    protected function defaultOrder($a, $b): int
    {
        return $b->getCreatedAt() <=> $a->getCreatedAt();
    }
}
