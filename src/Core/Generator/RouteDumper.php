<?php

declare(strict_types=1);

namespace App\Core\Generator;

use App\Content\ContentType;
use App\Core\Content\Accessor\ContentAccessorInterface;
use App\Core\Generator\Filesystem\ContentWriter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

final class RouteDumper
{
    public function __construct(
        private readonly RouterInterface          $router,
        private readonly HttpKernelInterface $httpKernel,
        private readonly ContentAccessorInterface $accessor
    ) {}

    public function dump(ContentWriter $writer): void
    {
        $routes = $this->router->getRouteCollection();

        $this->dumpContentPages($routes, $writer);
        $this->dumpStaticPages($routes, $writer);
    }

    private function dumpContentPages(RouteCollection $routes, ContentWriter $writer): void
    {
        foreach (ContentType::cases() as $contentType) {
            $slugs = $this->accessor->getSlugs($contentType);

            $route = $routes->get($contentType->value);

            foreach ($slugs as $slug) {
                $parameters = ['slug' => $slug];
                $writer->write(
                    $this->router->generate($contentType->value, $parameters),
                    $this->resolve($route, $parameters)
                );
            }
        }
    }

    private function dumpStaticPages(RouteCollection $routes, ContentWriter $writer): void
    {
        foreach ($routes as $route) {
            if (!$route instanceof Route) {
                continue;
            }

            if (empty($route->getRequirements())) {
                if ($route->getPath() === '/') {
                    continue;
                }
                $writer->write($route->getPath(), $this->resolve($route));
            }
        }
    }

    private function resolve(Route $route, array $parameters = []): string
    {
        $request = new Request();
        $request->attributes->set('_controller', $route->getDefault('_controller'));

        foreach ($parameters as $parameterName => $parameterValue) {
            $request->attributes->set($parameterName, $parameterValue);
        }

        $response = $this->httpKernel->handle($request);

        return $response->getContent();
    }
}
