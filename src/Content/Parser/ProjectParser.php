<?php

declare(strict_types=1);

namespace App\Content\Parser;

use App\Content\Model\Project;
use App\Core\Content\Parser\MarkdownParser;

final class ProjectParser extends MarkdownParser
{
    public function __construct()
    {
        parent::__construct(Project::class);
    }
}
