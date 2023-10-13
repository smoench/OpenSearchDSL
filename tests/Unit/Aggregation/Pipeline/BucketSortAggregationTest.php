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

namespace OpenSearchDSL\Tests\Unit\Aggregation\Pipeline;

use OpenSearchDSL\Aggregation\Pipeline\BucketSortAggregation;
use OpenSearchDSL\Sort\FieldSort;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for the bucket sort aggregation.
 */
class BucketSortAggregationTest extends TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $aggregation = new BucketSortAggregation('acme', 'test');

        $expected = [
            'bucket_sort' => [
                'buckets_path' => 'test',
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());

        $aggregation = new BucketSortAggregation('acme');

        $expected = [
            'bucket_sort' => [],
        ];

        $this->assertEquals($expected, $aggregation->toArray());

        $aggregation = new BucketSortAggregation('acme');
        $sort = new FieldSort('test_field', FieldSort::ASC);
        $aggregation->addSort($sort);

        $expected = [
            'bucket_sort' => [
                'sort' => [
                    [
                        'test_field' => [
                            'order' => 'asc',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }
}
