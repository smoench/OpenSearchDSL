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

/**
 * Class representing Avg Aggregation.
 *
 * @link http://goo.gl/7KOIwo
 */
class AvgAggregation extends StatsAggregation
{
    public function getType(): string
    {
        return 'avg';
    }
}
