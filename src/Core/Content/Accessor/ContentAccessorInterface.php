<?php

declare(strict_types=1);

namespace App\Core\Content\Accessor;

use App\Content\ContentType;
use App\Core\Content\Exception\ContentFileNotFoundException;

/**
 * Accessing files for a content type.
 */
interface ContentAccessorInterface
{
    /**
     * @return string file content
     * @throws ContentFileNotFoundException
     */
    public function access(ContentType $type, string $slug): string;

    /**
     * @return string[] files content
     * @throws ContentFileNotFoundException
     */
    public function accessAll(ContentType $type): array;

    public function getSlugs(ContentType $type): array;
}
