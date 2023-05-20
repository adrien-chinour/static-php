<?php

declare(strict_types=1);

namespace App\Core\Content\Accessor;

use App\Content\ContentType;
use App\Core\Content\Exception\ContentFileNotFoundException;
use Symfony\Component\Finder\Finder;

/**
 * Accessing markdown files for a content type inside project /content folder.
 */
final class ContentAccessor implements ContentAccessorInterface
{
    private const FILE_EXTENSION = '.md';

    public function __construct(
        private readonly string $projectDir
    ) {}

    /**
     * @return string file content
     * @throws ContentFileNotFoundException
     */
    public function access(ContentType $type, string $slug): string
    {
        try {
            $file = sprintf('%s/content/%s/%s%s', $this->projectDir, $type->value, $slug, self::FILE_EXTENSION);
            return file_get_contents($file);
        } catch (\Exception) {
            throw new ContentFileNotFoundException($file);
        }
    }

    /**
     * @return string[] files content
     * @throws ContentFileNotFoundException
     */
    public function accessAll(ContentType $type): array
    {
        return array_map(
            fn(\SplFileInfo $file) => $this->access($type, $file->getBasename(self::FILE_EXTENSION)),
            $this->getFiles($type)
        );
    }

    public function getSlugs(ContentType $type): array
    {
        return array_map(
            fn(\SplFileInfo $file) => $file->getBasename(self::FILE_EXTENSION),
            $this->getFiles($type)
        );
    }

    /**
     * @return \SplFileInfo[]
     */
    protected function getFiles(ContentType $type): array
    {
        ($finder = new Finder())->files()->in(sprintf('%s/content/%s/', $this->projectDir, $type->value));
        if (!$finder->hasResults()) {
            return [];
        }

        return iterator_to_array($finder);
    }
}
