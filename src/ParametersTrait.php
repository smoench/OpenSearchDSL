<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL;

/**
 * A trait which handles the behavior of parameters in queries, filters, etc.
 */
trait ParametersTrait
{
    /**
     * @var array<string, array|string|int|float|bool|object>
     */
    private array $parameters = [];

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]);
    }

    public function removeParameter(string $name): static
    {
        if ($this->hasParameter($name)) {
            unset($this->parameters[$name]);
        }

        return $this;
    }

    public function getParameter(string $name): array|string|int|float|bool|object
    {
        return $this->parameters[$name];
    }

    /**
     * @return array<string, array|string|int|float|bool|object>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameter(string $name, array|string|int|float|bool|object $value): static
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns given array merged with parameters.
     */
    protected function processArray(array $array = []): array
    {
        return array_merge($array, $this->parameters);
    }
}
