<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Aggregation\Pipeline;

use OpenSearchDSL\Aggregation\Pipeline\AvgBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for avg_bucket aggregation.
 */
class AvgBucketAggregationTest extends TestCase
{
    /**
     * Tests getArray method.
     */
    public function testGetArray()
    {
        $aggregation = new AvgBucketAggregation('foo', 'foo>bar');

        $this->assertEquals(['buckets_path' => 'foo>bar'], $aggregation->getArray());
    }

    /**
     * Tests getType method.
     */
    public function testAvgBucketAggregationGetType()
    {
        $aggregation = new AvgBucketAggregation('foo', 'foo>bar');
        $this->assertEquals('avg_bucket', $aggregation->getType());
    }
}
