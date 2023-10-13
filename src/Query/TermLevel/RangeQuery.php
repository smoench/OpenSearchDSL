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
    final public const LT = 'lt';

    final public const GT = 'gt';

    final public const LTE = 'lte';

    final public const GTE = 'gte';

    /**
     * @param string $field
     */
    public function __construct(
        private $field,
        array $parameters = []
    ) {
        $this->setParameters($parameters);

        if ($this->hasParameter(self::GTE) && $this->hasParameter(self::GT)) {
            unset($this->parameters[self::GT]);
        }

        if ($this->hasParameter(self::LTE) && $this->hasParameter(self::LT)) {
            unset($this->parameters[self::LT]);
        }
    }

    public function getType(): string
    {
        return 'range';
    }

    public function toArray(): array
    {
        $output = [
            $this->field => $this->getParameters(),
        ];

        return [
            $this->getType() => $output,
        ];
    }
}
