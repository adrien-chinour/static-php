<?php

declare(strict_types=1);

namespace App\Content\Repository;

use App\Content\ContentType;
use App\Content\Parser\ProjectParser;
use App\Core\Content\Accessor\ContentAccessorInterface;
use App\Core\Content\Repository\AbstractContentRepository;

/**
 * @extends AbstractContentRepository<Project>
 */
final class ProjectRepository extends AbstractContentRepository
{
    public function __construct(ProjectParser $parser, ContentAccessorInterface $accessor)
    {
        parent::__construct(ContentType::PROJECT, $parser, $accessor);
    }

    protected function defaultOrder($a, $b): int
    {
        if ($a->getEnd() === null) {
            return -1;
        }
        if ($b->getEnd() === null) {
            return 1;
        }

        return $b->getStart() <=> $a->getStart();
    }
}
