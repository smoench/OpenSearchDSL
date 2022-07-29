<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Query\Span;

use LogicException;
use OpenSearchDSL\ParametersTrait;

/**
 * Elasticsearch span first query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
 */
class SpanFirstQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * @param SpanQueryInterface $query
     * @param int                $end
     * @param array              $parameters
     *
     * @throws LogicException
     */
    public function __construct(private SpanQueryInterface $query, private $end, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'span_first';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [];
        $query['match'] = $this->query->toArray();
        $query['end'] = $this->end;
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
