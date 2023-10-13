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

namespace OpenSearchDSL\Tests\Unit\Aggregation\Bucketing;

use LogicException;
use OpenSearchDSL\Aggregation\Bucketing\GlobalAggregation;
use PHPUnit\Framework\TestCase;
use stdClass;

class GlobalAggregationTest extends TestCase
{
    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getToArrayData()
    {
        $out = [];

        // Case #0 global aggregation.
        $aggregation = new GlobalAggregation('test_agg');

        $result = [
            'global' => new stdClass(),
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #1 nested global aggregation.
        $aggregation = new GlobalAggregation('test_agg');
        $aggregation2 = new GlobalAggregation('test_agg_2');
        $aggregation->addAggregation($aggregation2);

        $result = [
            'global' => new stdClass(),
            'aggregations' => [
                $aggregation2->getName() => $aggregation2->toArray(),
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        return $out;
    }

    /**
     * Test for global aggregation toArray() method.
     *
     * @param GlobalAggregation $aggregation
     * @param array             $expectedResult
     *
     * @dataProvider getToArrayData
     */
    public function testToArray($aggregation, $expectedResult)
    {
        $this->assertEquals(
            json_encode($expectedResult, JSON_THROW_ON_ERROR),
            json_encode($aggregation->toArray(), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * Test for setField method on global aggregation.
     */
    public function testSetField()
    {
        $this->expectException(LogicException::class);
        $aggregation = new GlobalAggregation('test_agg');
        $aggregation->setField('test_field');
    }
}
