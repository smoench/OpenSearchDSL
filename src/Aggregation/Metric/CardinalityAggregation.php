<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Aggregation\Metric;

use LogicException;
use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\MetricTrait;
use OpenSearchDSL\ScriptAwareTrait;

/**
 * Difference values counter.
 *
 * @link http://goo.gl/tG7ciG
 */
class CardinalityAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    private ?int $precisionThreshold = null;

    private ?bool $rehash = null;

    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'precision_threshold' => $this->getPrecisionThreshold(),
                'rehash' => $this->isRehash(),
            ],
            fn ($val) => $val || is_bool($val)
        );

        $this->checkRequiredFields($out);

        return $out;
    }

    /**
     * @param int $precision
     *
     * @return $this
     */
    public function setPrecisionThreshold($precision)
    {
        $this->precisionThreshold = $precision;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrecisionThreshold()
    {
        return $this->precisionThreshold;
    }

    /**
     * @return bool
     */
    public function isRehash()
    {
        return $this->rehash;
    }

    /**
     * @param bool $rehash
     *
     * @return $this
     */
    public function setRehash($rehash)
    {
        $this->rehash = $rehash;

        return $this;
    }

    public function getType(): string
    {
        return 'cardinality';
    }

    /**
     * Checks if required fields are set.
     *
     * @param array $fields
     *
     * @throws LogicException
     */
    private function checkRequiredFields($fields)
    {
        if (! array_key_exists('field', $fields) && ! array_key_exists('script', $fields)) {
            throw new LogicException('Cardinality aggregation must have field or script set.');
        }
    }
}
