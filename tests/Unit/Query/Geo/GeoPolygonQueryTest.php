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

namespace OpenSearchDSL\Tests\Unit\Query\Geo;

use OpenSearchDSL\Query\Geo\GeoPolygonQuery;
use PHPUnit\Framework\TestCase;

class GeoPolygonQueryTest extends TestCase
{
    /**
     * Data provider to testToArray.
     *
     * @return array
     */
    public static function getArrayDataProvider()
    {
        return [
            // Case #1.
            [
                'location',
                [
                    [
                        'lat' => 20,
                        'lon' => -80,
                    ],
                    [
                        'lat' => 30,
                        'lon' => -40,
                    ],
                    [
                        'lat' => 70,
                        'lon' => -90,
                    ],
                ],
                [],
                [
                    'location' => [
                        'points' => [
                            [
                                'lat' => 20,
                                'lon' => -80,
                            ],
                            [
                                'lat' => 30,
                                'lon' => -40,
                            ],
                            [
                                'lat' => 70,
                                'lon' => -90,
                            ],
                        ],
                    ],
                ],
            ],
            // Case #2.
            [
                'location',
                [],
                [
                    'parameter' => 'value',
                ],
                [
                    'location' => [
                        'points' => [],
                    ],
                    'parameter' => 'value',
                ],
            ],
            // Case #3.
            [
                'location',
                [
                    [
                        'lat' => 20,
                        'lon' => -80,
                    ],
                ],
                [
                    'parameter' => 'value',
                ],
                [
                    'location' => [
                        'points' => [[
                            'lat' => 20,
                            'lon' => -80,
                        ]],
                    ],
                    'parameter' => 'value',
                ],
            ],
        ];
    }

    /**
     * Tests toArray method.
     *
     * @param string $field      Field name.
     * @param array  $points     Polygon's points.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected result.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getArrayDataProvider')]
    public function testToArray($field, $points, $parameters, $expected)
    {
        $filter = new GeoPolygonQuery($field, $points, $parameters);
        $result = $filter->toArray();
        $this->assertEquals([
            'geo_polygon' => $expected,
        ], $result);
    }
}
