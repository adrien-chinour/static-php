<?php

declare(strict_types=1);

namespace App\Core\Generator\Filesystem;

use Symfony\Component\Filesystem\Filesystem;

final class ContentWriter
{
    private Filesystem $filesystem;

    public function __construct(private readonly string $outputDir)
    {
        $this->filesystem = new Filesystem();
    }

    public function setFilesystem(Filesystem $filesystem): void
    {
        $this->filesystem = $filesystem;
    }

    public function write(string $path, string $content): void
    {
        $this->filesystem->dumpFile(sprintf('%s%s', $this->outputDir, $path), $content);
    }
}
