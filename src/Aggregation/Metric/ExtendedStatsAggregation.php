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

use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\MetricTrait;
use OpenSearchDSL\ScriptAwareTrait;

/**
 * Class representing Extended stats aggregation.
 *
 * @link http://goo.gl/E0PpDv
 */
class ExtendedStatsAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param int    $sigma
     * @param string $script
     */
    public function __construct($name, $field = null, $sigma = null, $script = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setSigma($sigma);
        $this->setScript($script);
    }

    private int $sigma;

    /**
     * @return int
     */
    public function getSigma()
    {
        return $this->sigma;
    }

    /**
     * @param int $sigma
     *
     * @return $this
     */
    public function setSigma($sigma)
    {
        $this->sigma = $sigma;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'extended_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'sigma' => $this->getSigma(),
            ],
            fn($val) => $val || is_numeric($val)
        );
    }
}
