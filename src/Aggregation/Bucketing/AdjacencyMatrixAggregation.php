<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Aggregation\Bucketing;

use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\BucketingTrait;
use OpenSearchDSL\BuilderInterface;

/**
 * Class representing adjacency matrix aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-adjacency-matrix-aggregation.html
 */
class AdjacencyMatrixAggregation extends AbstractAggregation
{
    public const FILTERS = 'filters';

    use BucketingTrait;

    /**
     * @var array<string, array<string, array|null>>
     */
    private array $filters = [
        self::FILTERS => []
    ];

    /**
     * @param array<string, BuilderInterface> $filters
     */
    public function __construct(string $name, array $filters = [])
    {
        parent::__construct($name);

        foreach ($filters as $filterName => $filter) {
            $this->addFilter($filterName, $filter);
        }
    }

    public function addFilter(string $name, BuilderInterface $filter): self
    {
        $this->filters[self::FILTERS][$name] = $filter->toArray() ?: null;

        return $this;
    }

    public function getArray(): array
    {
        return $this->filters;
    }

    public function getType(): string
    {
        return 'adjacency_matrix';
    }
}
