<?php

declare(strict_types=1);

namespace App\Core\Content;

interface ContentInterface
{
    public function getSlug();

    public function getContent();
}
