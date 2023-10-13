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

namespace OpenSearchDSL\Query\Compound;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "constant_score" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
 */
class ConstantScoreQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private BuilderInterface $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'constant_score';
    }

    public function toArray(): array
    {
        $query = [
            'filter' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
