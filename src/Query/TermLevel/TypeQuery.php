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
 * Represents Elasticsearch "type" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-type-query.html
 */
class TypeQuery implements BuilderInterface
{
    /**
     * Constructor.
     *
     * @param string $type Type name
     */
    public function __construct(private $type)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'type';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            $this->getType() => [
                'value' => $this->type,
            ],
        ];
    }
}
