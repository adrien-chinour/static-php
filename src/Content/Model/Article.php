<?php

declare(strict_types=1);

namespace App\Content\Model;

use App\Core\Content\ContentInterface;

class Article implements ContentInterface
{
    private string $slug;

    private string $title;

    private \DateTimeInterface $createdAt;

    private string $content;

    private array $tags;

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): Article
    {
        $this->slug = $slug;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): Article
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Article
    {
        $this->content = $content;
        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): Article
    {
        $this->tags = $tags;
        return $this;
    }
}
