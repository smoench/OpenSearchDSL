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
use OpenSearchDSL\Aggregation\Bucketing\GeoHashGridAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for geohash grid aggregation.
 */
class GeoHashGridAggregationTest extends TestCase
{
    /**
     * Test if exception is thrown.
     */
    public function testGeoHashGridAggregationException()
    {
        $this->expectException(LogicException::class);
        $agg = new GeoHashGridAggregation('test_agg');
        $agg->getArray();
    }

    /**
     * Data provider for testGeoHashGridAggregationGetArray().
     */
    public static function getArrayDataProvider(): iterable
    {
        yield [
            'filterData' => [
                'field' => 'location',
                'precision' => 3,
                'size' => 10,
                'shard_size' => 10,
            ],
            'expectedResults' => [
                'field' => 'location',
                'precision' => 3,
                'size' => 10,
                'shard_size' => 10,
            ],
        ];
    }

    /**
     * Tests getArray method.
     *
     * @param array $filterData
     * @param array $expected
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getArrayDataProvider')]
    public function testGeoHashGridAggregationGetArray($filterData, $expected)
    {
        $aggregation = new GeoHashGridAggregation('foo');
        $aggregation->setPrecision($filterData['precision']);
        $aggregation->setSize($filterData['size']);
        $aggregation->setShardSize($filterData['shard_size']);
        $aggregation->setField($filterData['field']);

        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected);
    }

    /**
     * Tests getType method.
     */
    public function testGeoHashGridAggregationGetType()
    {
        $aggregation = new GeoHashGridAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('geohash_grid', $result);
    }
}
