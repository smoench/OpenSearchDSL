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

namespace OpenSearchDSL\Query\TermLevel;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "ids" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 */
class IdsQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private array $values,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'ids';
    }

    public function toArray(): array
    {
        $query = [
            'values' => $this->values,
        ];

        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
