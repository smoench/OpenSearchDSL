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
 * Class representing Max Bucket Pipeline Aggregation.
 *
 * @link https://goo.gl/8gIfok
 */
class MovingAverageAggregation extends AbstractPipelineAggregation
{
    public function getType(): string
    {
        return 'moving_avg';
    }
}
