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
    const FILTERS = 'filters';

    use BucketingTrait;

    /**
     * @var BuilderInterface[]
     */
    private $filters = [
        self::FILTERS => []
    ];

    /**
     * Inner aggregations container init.
     *
     * @param string             $name
     * @param BuilderInterface[] $filters
     */
    public function __construct($name, $filters = [])
    {
        parent::__construct($name);

        foreach ($filters as $name => $filter) {
            $this->addFilter($name, $filter);
        }
    }

    /**
     * @param string           $name
     * @param BuilderInterface $filter
     *
     * @throws \LogicException
     *
     * @return self
     */
    public function addFilter($name, BuilderInterface $filter)
    {
        $this->filters[self::FILTERS][$name] = $filter->toArray();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'adjacency_matrix';
    }
}
