<?php

declare(strict_types=1);

namespace App\Core\Generator;

use App\Core\Generator\Filesystem\ContentWriter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('site:generate', 'Generate static site.')]
final class StaticSiteGeneratorCommand extends Command
{
    public function __construct(private readonly RouteDumper $dumper, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $writer = new ContentWriter(dirname(__DIR__, 3) . '/static');
        $this->dumper->dump($writer);
        return Command::SUCCESS;
    }
}
