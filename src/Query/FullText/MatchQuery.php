<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Query\FullText;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "match" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class MatchQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $field
     * @param string $query
     */
    public function __construct(
        private $field,
        private $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'match';
    }

    public function toArray(): array
    {
        $query = [
            'query' => $this->query,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [
            $this->getType() => $output,
        ];
    }
}
