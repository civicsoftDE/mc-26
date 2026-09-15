<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavigationExtension extends AbstractExtension
{
    public function __construct(
        private RequestStack $requestStack,
    )
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_active_section', $this->isActiveSection(...)),
            new TwigFunction('active_class', $this->getActiveClass(...)),
        ];
    }

    /**
     * @param string|string[] $routePrefixes Ein oder mehrere Prefixe
     */
    public function isActiveSection(string|array $routePrefixes): bool
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return false;
        }

        $currentRoute = $request->attributes->get('_route', '');
        $prefixes = (array)$routePrefixes;

        foreach ($prefixes as $prefix) {
            if (str_starts_with($currentRoute, $prefix)) {
                return true;
            }
        }

        return false;
    }

    public function getActiveClass(string|array $routePrefixes, string $class = 'active'): string
    {
        return $this->isActiveSection($routePrefixes) ? $class : '';
    }
}
