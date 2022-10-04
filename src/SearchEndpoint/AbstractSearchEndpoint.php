<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\SearchEndpoint;

use BadFunctionCallException;
use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;
use OpenSearchDSL\Query\Compound\BoolQuery;
use OpenSearchDSL\Serializer\Normalizer\AbstractNormalizable;
use OverflowException;

/**
 * Abstract class used to define search endpoint with references.
 */
abstract class AbstractSearchEndpoint extends AbstractNormalizable implements SearchEndpointInterface
{
    use ParametersTrait;

    public const NAME = 'abstract';

    /**
     * @var array<string, BuilderInterface>
     */
    private array $container = [];

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        if (array_key_exists($key, $this->container)) {
            throw new OverflowException(sprintf('Builder with %s name for endpoint has already been added!', $key));
        }

        if (! $key) {
            $key = bin2hex(random_bytes(30));
        }

        $this->container[$key] = $builder;

        return $key;
    }

    public function addToBool(
        BuilderInterface $builder,
        string $boolType = BoolQuery::MUST,
        ?string $key = null
    ): string {
        throw new BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::NAME));
    }

    public function remove(string $key): static
    {
        if ($this->has($key)) {
            unset($this->container[$key]);
        }

        return $this;
    }

    /**
     * Checks if builder with specific key exists.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->container);
    }

    public function get(string $key): ?BuilderInterface
    {
        return $this->container[$key] ?? null;
    }

    public function getAll(?string $boolType = null): array
    {
        return $this->container;
    }

    public function getBool(): ?BoolQuery
    {
        throw new BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::NAME));
    }
}
