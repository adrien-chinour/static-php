<?php

declare(strict_types=1);

namespace App\Core\Content\Repository;

use App\Content\ContentType;
use App\Core\Content\Accessor\ContentAccessorInterface;
use App\Core\Content\Exception\ContentException;
use App\Core\Content\Parser\ParserInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * @template T
 */
abstract class AbstractContentRepository implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        protected readonly ContentType              $contentType,
        protected readonly ParserInterface          $parser,
        protected readonly ContentAccessorInterface $accessor
    ) {}

    /**
     * @return T[]
     */
    public function findAll(): array
    {
        $contents = [];

        try {
            foreach ($this->accessor->accessAll($this->contentType) as $rawContent) {
                $contents[] = $this->parser->parse($rawContent);
            }
        } catch (ContentException $exception) {
            $this->logger?->critical($exception->getMessage());
        }

        usort($contents, fn($a, $b) => $this->defaultOrder($a, $b));

        return $contents;
    }

    /**
     * @return null|T
     */
    public function find(string $slug): ?object
    {
        $object = null;

        try {
            $rawProject = $this->accessor->access($this->contentType, $slug);
            $object = $this->parser->parse($rawProject);
        } catch (ContentException $exception) {
            $this->logger?->critical($exception->getMessage());
        }

        return $object;
    }

    /**
     * Default order used by findAll method.
     *
     * @param T $a
     * @param T $b
     * @return int
     */
    protected function defaultOrder($a, $b): int
    {
        return -1;
    }
}
