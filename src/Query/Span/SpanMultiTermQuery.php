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

namespace OpenSearchDSL\Query\Span;

use InvalidArgumentException;
use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Elasticsearch span multi term query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-multi-term-query.html
 */
class SpanMultiTermQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * Accepts one of fuzzy, prefix, term range, wildcard, regexp query.
     */
    public function __construct(
        private readonly BuilderInterface $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'span_multi';
    }

    /**
     * @throws InvalidArgumentException
     */
    public function toArray(): array
    {
        $query = [];
        $query['match'] = $this->query->toArray();
        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
