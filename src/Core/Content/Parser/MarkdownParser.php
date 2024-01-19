<?php

declare(strict_types=1);

namespace App\Core\Content\Parser;

use App\Core\Content\ContentInterface;
use App\Core\Content\Exception\ContentParseException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @template T
 */
abstract class MarkdownParser implements ParserInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private string $contentClass;

    private SerializerInterface $serializer;

    public function __construct(string $contentClass)
    {
        $this->contentClass = $contentClass;
        $this->serializer = new MarkdownHeadersSerializer();
    }

    /**
     * @return T
     * @throws ContentParseException
     */
    public function parse(string $content): object
    {
        $this->logger?->debug('Parse markdown data.');

        $data = explode('---', $content);
        if (null === ($data[1] ?? null) || null === ($data[2] ?? null)) {
            throw new ContentParseException("Failed to parse data.");
        }

        /** @var ContentInterface $object */
        $object = new ($this->contentClass)();

        $this->parseHeaders($object, $data[1]);
        $this->parseContent($object, $data[2]);

        return $object;
    }

    protected function parseHeaders($object, string $rawHeaders): void
    {
        $this->serializer->deserialize(
            $rawHeaders,
            $this->contentClass,
            'yaml',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $object]
        );
    }

    protected function parseContent($object, string $rawContent): void
    {
        $object->setContent((new \Parsedown())->parse($rawContent));
    }
}
