<?php

declare(strict_types=1);

namespace App\Core\Content\Parser;

/**
 * Deserialize content data.
 */
interface ParserInterface
{
    public function parse(string $content): object;
}
