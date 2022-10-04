<?php

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
 * Class representing Derivative Pipeline Aggregation.
 *
 * @link https://goo.gl/Tt2MIR
 */
class DerivativeAggregation extends AbstractPipelineAggregation
{
    public function getType(): string
    {
        return 'derivative';
    }
}
