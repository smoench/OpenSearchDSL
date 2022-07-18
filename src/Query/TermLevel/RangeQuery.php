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
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "range" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
 */
class RangeQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * Range control names.
     */
    public const LT = 'lt';
    public const GT = 'gt';
    public const LTE = 'lte';
    public const GTE = 'gte';

    /**
     * @param string $field
     * @param array  $parameters
     */
    public function __construct(private $field, array $parameters = [])
    {
        $this->setParameters($parameters);

        if ($this->hasParameter(self::GTE) && $this->hasParameter(self::GT)) {
            unset($this->parameters[self::GT]);
        }

        if ($this->hasParameter(self::LTE) && $this->hasParameter(self::LT)) {
            unset($this->parameters[self::LT]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'range';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $output = [
            $this->field => $this->getParameters(),
        ];

        return [$this->getType() => $output];
    }
}
