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

namespace OpenSearchDSL\Aggregation\Metric;

use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\MetricTrait;

/**
 * Class representing StatsAggregation.
 *
 * @link http://goo.gl/JbQsI3
 */
class ScriptedMetricAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var mixed
     */
    private $initScript;

    /**
     * @var mixed
     */
    private $mapScript;

    /**
     * @var mixed
     */
    private $combineScript;

    /**
     * @var mixed
     */
    private $reduceScript;

    /**
     * ScriptedMetricAggregation constructor.
     * @param string $name
     * @param mixed $initScript
     * @param mixed $mapScript
     * @param mixed $combineScript
     * @param mixed $reduceScript
     */
    public function __construct(
        $name,
        $initScript = null,
        $mapScript = null,
        $combineScript = null,
        $reduceScript = null
    ) {
        parent::__construct($name);

        $this->setInitScript($initScript);
        $this->setMapScript($mapScript);
        $this->setCombineScript($combineScript);
        $this->setReduceScript($reduceScript);
    }

    public function getType(): string
    {
        return 'scripted_metric';
    }

    /**
     * @return mixed
     */
    public function getInitScript()
    {
        return $this->initScript;
    }

    /**
     * @return $this
     */
    public function setInitScript(mixed $initScript)
    {
        $this->initScript = $initScript;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMapScript()
    {
        return $this->mapScript;
    }

    /**
     * @return $this
     */
    public function setMapScript(mixed $mapScript)
    {
        $this->mapScript = $mapScript;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCombineScript()
    {
        return $this->combineScript;
    }

    /**
     * @return $this
     */
    public function setCombineScript(mixed $combineScript)
    {
        $this->combineScript = $combineScript;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReduceScript()
    {
        return $this->reduceScript;
    }

    /**
     * @return $this
     */
    public function setReduceScript(mixed $reduceScript)
    {
        $this->reduceScript = $reduceScript;

        return $this;
    }

    public function getArray(): array
    {
        return array_filter(
            [
                'init_script' => $this->getInitScript(),
                'map_script' => $this->getMapScript(),
                'combine_script' => $this->getCombineScript(),
                'reduce_script' => $this->getReduceScript(),
            ]
        );
    }
}
