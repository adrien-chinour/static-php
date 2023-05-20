<?php

declare(strict_types=1);

namespace App\Content;

enum ContentType: string
{
    case ARTICLE = 'article';
    case PROJECT = 'project';
}
