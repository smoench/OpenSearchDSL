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

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\Query\Compound\BoolQuery;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * Interface used to define search endpoint.
 */
interface SearchEndpointInterface extends NormalizableInterface
{
    /**
     * Adds builder to search endpoint.
     *
     * @param BuilderInterface $builder Builder to add.
     * @param string|null $key Optional key for builder to add.
     *
     * @return string Key of added builder.
     */
    public function add(BuilderInterface $builder, ?string $key = null): string;

    /**
     * Adds builder to search endpoint's specific bool type container.
     *
     * @param BuilderInterface $builder Builder to add.
     * @param string $boolType Bool type for query or filter.
     * @param string|null $key Additional parameters relevant to builder.
     *
     * @return string Key of added builder.
     */
    public function addToBool(
        BuilderInterface $builder,
        string $boolType = BoolQuery::MUST,
        ?string $key = null
    ): string;

    /**
     * Removes contained builder.
     */
    public function remove(string $key): static;

    /**
     * Returns contained builder or null if Builder is not found.
     */
    public function get(string $key): ?BuilderInterface;

    /**
     * Returns contained builder or null if Builder is not found.
     *
     * @param string|null $boolType If bool type is left null it will return all builders from container.
     *
     * @return array<string, BuilderInterface>
     */
    public function getAll(?string $boolType = null): array;

    /**
     * Returns Bool filter or query instance with all builder objects inside.
     */
    public function getBool(): ?BoolQuery;
}
