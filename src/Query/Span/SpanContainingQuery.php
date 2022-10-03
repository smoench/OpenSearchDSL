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

use OpenSearchDSL\ParametersTrait;

/**
 * Elasticsearch span containing query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class SpanContainingQuery implements SpanQueryInterface
{
    use ParametersTrait;

    public function __construct(
        private SpanQueryInterface $little,
        private SpanQueryInterface $big
    ) {
    }

    public function getLittle(): SpanQueryInterface
    {
        return $this->little;
    }

    public function getBig(): SpanQueryInterface
    {
        return $this->big;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'span_containing';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $output = [
            'little' => $this->getLittle()->toArray(),
            'big' => $this->getBig()->toArray(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }
}
