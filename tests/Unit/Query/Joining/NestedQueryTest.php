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

namespace OpenSearchDSL\Tests\Unit\Query\Joining;

use OpenSearchDSL\Query\Joining\NestedQuery;
use OpenSearchDSL\Query\TermLevel\TermsQuery;
use PHPUnit\Framework\TestCase;

class NestedQueryTest extends TestCase
{
    /**
     * Data provider to testGetToArray.
     *
     * @return array
     */
    public static function getArrayDataProvider()
    {
        $query = [
            'terms' => [
                'foo' => 'bar',
            ],
        ];

        return [
            'query_only' => [
                'product.sub_item',
                [],
                [
                    'path' => 'product.sub_item',
                    'query' => $query,
                ],
            ],
            'query_with_parameters' => [
                'product.sub_item',
                [
                    '_cache' => true,
                    '_name' => 'named_result',
                ],
                [
                    'path' => 'product.sub_item',
                    'query' => $query,
                    '_cache' => true,
                    '_name' => 'named_result',
                ],
            ],
        ];
    }

    /**
     * Test for query toArray() method.
     *
     * @param string $path
     * @param array  $parameters
     * @param array  $expected
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('getArrayDataProvider')]
    public function testToArray($path, $parameters, $expected)
    {
        $query = new TermsQuery('foo', 'bar');
        $query = new NestedQuery($path, $query, $parameters);
        $result = $query->toArray();
        $this->assertEquals([
            'nested' => $expected,
        ], $result);
    }
}
