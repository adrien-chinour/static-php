<?php

declare(strict_types=1);

namespace App\Core\Content\Parser;

use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class MarkdownHeadersSerializer implements SerializerInterface
{
    private SerializerInterface $decorated;

    public function __construct()
    {
        $dateCallback = fn($property) => \DateTime::createFromFormat('Y-m-d', $property);

        // FIXME work on a automatic normalizer for datetime properties
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => $dateCallback,
                'start' => $dateCallback,
                'end' => $dateCallback,
            ],
        ];

        $this->decorated = new Serializer(
            [new GetSetMethodNormalizer(defaultContext: $defaultContext)],
            [new YamlEncoder()]
        );
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->decorated->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->decorated->deserialize($data, $type, $format, $context);
    }
}
