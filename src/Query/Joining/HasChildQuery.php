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

namespace OpenSearchDSL\Query\Joining;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "has_child" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-child-query.html
 */
class HasChildQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string           $type
     */
    public function __construct(
        private $type,
        private readonly BuilderInterface $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'has_child';
    }

    public function toArray(): array
    {
        $query = [
            'type' => $this->type,
            'query' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
