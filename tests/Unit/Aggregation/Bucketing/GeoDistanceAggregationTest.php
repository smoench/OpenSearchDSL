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
use OpenSearchDSL\Aggregation\Bucketing\GeoDistanceAggregation;
use PHPUnit\Framework\TestCase;

class GeoDistanceAggregationTest extends TestCase
{
    /**
     * Test if exception is thrown when field is not set.
     */
    public function testGeoDistanceAggregationExceptionWhenFieldIsNotSet()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Geo distance aggregation must have a field set.");
        $agg = new GeoDistanceAggregation('test_agg');
        $agg->setOrigin('50, 70');
        $agg->getArray();
    }

    /**
     * Test if exception is thrown when origin is not set.
     */
    public function testGeoDistanceAggregationExceptionWhenOriginIsNotSet()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Geo distance aggregation must have an origin set.");
        $agg = new GeoDistanceAggregation('test_agg');
        $agg->setField('location');
        $agg->getArray();
    }

    /**
     * Test if exception is thrown when field is not set.
     */
    public function testGeoDistanceAggregationAddRangeException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Either from or to must be set. Both cannot be null.");
        $agg = new GeoDistanceAggregation('test_agg');
        $agg->addRange();
    }

    /**
     * Data provider for testGeoDistanceAggregationGetArray().
     */
    public static function getGeoDistanceAggregationGetArrayDataProvider(): iterable
    {
        yield [
            'filterData' => [
                'field' => 'location',
                'origin' => '52.3760, 4.894',
                'unit' => 'mi',
                'distance_type' => 'plane',
                'ranges' => [100, 300],
            ],
            'expectedResults' => [
                'field' => 'location',
                'origin' => '52.3760, 4.894',
                'unit' => 'mi',
                'distance_type' => 'plane',
                'ranges' => [[
                    'from' => 100,
                    'to' => 300,
                ]],
            ],
        ];
    }

    /**
     * Tests getArray method.
     *
     * @param array $filterData
     * @param array $expected
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getGeoDistanceAggregationGetArrayDataProvider')]
    public function testGeoDistanceAggregationGetArray($filterData, $expected)
    {
        $aggregation = new GeoDistanceAggregation('foo');
        $aggregation->setOrigin($filterData['origin']);
        $aggregation->setField($filterData['field']);
        $aggregation->setUnit($filterData['unit']);
        $aggregation->setDistanceType($filterData['distance_type']);
        $aggregation->addRange($filterData['ranges'][0], $filterData['ranges'][1]);

        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected);
    }

    /**
     * Tests getType method.
     */
    public function testGeoDistanceAggregationGetType()
    {
        $aggregation = new GeoDistanceAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('geo_distance', $result);
    }

    /**
     * Tests if parameters can be passed to constructor.
     */
    public function testConstructorFilter()
    {
        $aggregation = new GeoDistanceAggregation(
            'test',
            'fieldName',
            'originValue',
            [
                [
                    'from' => 'value',
                ],
                [
                    'to' => 'value',
                ],
                [
                    'from' => 'value',
                    'to' => 'value2',
                ],
            ],
            'unitValue',
            'distanceTypeValue'
        );

        $this->assertSame(
            [
                'geo_distance' => [
                    'field' => 'fieldName',
                    'origin' => 'originValue',
                    'unit' => 'unitValue',
                    'distance_type' => 'distanceTypeValue',
                    'ranges' => [
                        [
                            'from' => 'value',
                        ],
                        [
                            'to' => 'value',
                        ],
                        [
                            'from' => 'value',
                            'to' => 'value2',
                        ],
                    ],
                ],
            ],
            $aggregation->toArray()
        );
    }
}
