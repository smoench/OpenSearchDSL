<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Aggregation\Bucketing;

use LogicException;
use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class DateHistogramAggregationTest extends TestCase
{
    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayException()
    {
        $this->expectException(LogicException::class);
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testDateHistogramAggregationGetType()
    {
        $aggregation = new DateHistogramAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('date_histogram', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray()
    {
        $mock = $this->createMock(AbstractAggregation::class);
        $mock->method('getName')->willReturn('abstract');

        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->addAggregation($mock);
        $aggregation->setField('date');
        $aggregation->setInterval('month');
        $result = $aggregation->getArray();
        $expected = [
            'field' => 'date',
            'interval' => 'month',
        ];
        $this->assertEquals($expected, $result);
    }
}
