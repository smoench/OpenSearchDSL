<?php

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

/**
 * Represents Elasticsearch "exists" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class ExistsQuery implements BuilderInterface
{
    /**
     * Constructor.
     *
     * @param string $field Field value
     */
    public function __construct(
        private $field
    ) {
    }

    public function getType(): string
    {
        return 'exists';
    }

    public function toArray(): array
    {
        return [
            $this->getType() => [
                'field' => $this->field,
            ],
        ];
    }
}
