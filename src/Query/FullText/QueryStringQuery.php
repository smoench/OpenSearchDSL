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

namespace OpenSearchDSL\Query\FullText;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "query_string" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
 */
class QueryStringQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $query
     */
    public function __construct(
        private $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'query_string';
    }

    public function toArray(): array
    {
        $query = [
            'query' => $this->query,
        ];

        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
