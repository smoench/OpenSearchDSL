<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Query\Joining;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "has_parent" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-parent-query.html
 */
class HasParentQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string           $parentType
     * @param BuilderInterface $query
     * @param array            $parameters
     */
    public function __construct(private $parentType, private BuilderInterface $query, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'has_parent';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'parent_type' => $this->parentType,
            'query' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
