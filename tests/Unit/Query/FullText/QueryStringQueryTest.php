<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\FullText;

use OpenSearchDSL\Query\FullText\QueryStringQuery;
use PHPUnit\Framework\TestCase;

class QueryStringQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new QueryStringQuery('this AND that OR thus');
        $expected = [
            'query_string' => [
                'query' => 'this AND that OR thus',
            ]
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
