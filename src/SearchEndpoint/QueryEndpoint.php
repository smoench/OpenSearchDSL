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
use OpenSearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search query dsl endpoint.
 */
class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    /**
     * Endpoint name
     */
    public const NAME = 'query';

    private ?BoolQuery $bool = null;

    private bool $filtersSet = false;

    public function normalize(
        NormalizerInterface $normalizer,
        string $format = null,
        array $context = []
    ): array|string|int|float|bool {
        if (! $this->filtersSet && $this->hasReference('filter_query')) {
            /** @var BuilderInterface $filter */
            $filter = $this->getReference('filter_query');
            $this->addToBool($filter, BoolQuery::FILTER);
            $this->filtersSet = true;
        }

        if ($this->bool === null) {
            return false;
        }

        return $this->bool->toArray();
    }

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        return $this->addToBool($builder, BoolQuery::MUST, $key);
    }

    public function addToBool(
        BuilderInterface $builder,
        string $boolType = BoolQuery::MUST,
        ?string $key = null
    ): string {
        if ($this->bool === null) {
            $this->bool = new BoolQuery();
        }

        return $this->bool->add($builder, $boolType, $key);
    }

    public function getOrder(): int
    {
        return 2;
    }

    public function getBool(): ?BoolQuery
    {
        return $this->bool;
    }

    public function getAll(?string $boolType = null): array
    {
        return $this->bool->getQueries($boolType);
    }
}
