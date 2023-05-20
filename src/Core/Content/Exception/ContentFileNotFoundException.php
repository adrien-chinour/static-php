<?php

declare(strict_types=1);

namespace App\Core\Content\Exception;

final class ContentFileNotFoundException extends ContentException
{
    public function __construct(string $file)
    {
        parent::__construct(sprintf('File %s not found.', $file));
    }
}
