<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Metric\Aggregation;

use OpenSearchDSL\Aggregation\Metric\StatsAggregation;
use PHPUnit\Framework\TestCase;

class StatsAggregationTest extends TestCase
{
    /**
     * Test for stats aggregation toArray() method.
     */
    public function testToArray()
    {
        $aggregation = new StatsAggregation('test_agg');
        $aggregation->setField('test_field');

        $expectedResult = [
            'stats' => [
                'field' => 'test_field',
            ],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Tests if parameter can be passed to constructor.
     */
    public function testConstructor()
    {
        $aggregation = new StatsAggregation('foo', 'fieldValue', 'scriptValue');
        $this->assertSame(
            [
                'stats' => [
                    'field' => 'fieldValue',
                    'script' => 'scriptValue',
                ],
            ],
            $aggregation->toArray()
        );
    }
}
