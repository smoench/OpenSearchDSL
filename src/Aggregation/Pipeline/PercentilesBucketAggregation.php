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

namespace OpenSearchDSL\Aggregation\Pipeline;

/**
 * Class representing Percentiles Bucket Pipeline Aggregation.
 *
 * @link https://goo.gl/bqi7m5
 */
class PercentilesBucketAggregation extends AbstractPipelineAggregation
{
    private ?array $percents = null;

    public function getType(): string
    {
        return 'percentiles_bucket';
    }

    /**
     * @return array
     */
    public function getPercents()
    {
        return $this->percents;
    }

    /**
     * @return $this
     */
    public function setPercents(array $percents)
    {
        $this->percents = $percents;

        return $this;
    }

    public function getArray(): array
    {
        $data = [
            'buckets_path' => $this->getBucketsPath(),
        ];

        if ($this->getPercents()) {
            $data['percents'] = $this->getPercents();
        }

        return $data;
    }
}
