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

namespace OpenSearchDSL\Tests\Unit\Aggregation\Metric;

use LogicException;
use OpenSearchDSL\Aggregation\Metric\GeoCentroidAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class GeoCentroidAggregationTest extends TestCase
{
    /**
     * Test if exception is thrown when field is not provided
     */
    public function testGetArrayException()
    {
        $this->expectException(LogicException::class);
        $aggregation = new GeoCentroidAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testGeoCentroidAggregationGetType()
    {
        $aggregation = new GeoCentroidAggregation('foo');
        $this->assertEquals('geo_centroid', $aggregation->getType());
    }

    /**
     * Tests getArray method.
     */
    public function testGeoCentroidAggregationGetArray()
    {
        $aggregation = new GeoCentroidAggregation('foo', 'location');
        $this->assertEquals([
            'field' => 'location',
        ], $aggregation->getArray());
    }
}
