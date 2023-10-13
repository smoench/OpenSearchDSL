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

namespace OpenSearchDSL\Tests\Unit\Query\FullText;

use OpenSearchDSL\Query\FullText\SimpleQueryStringQuery;
use PHPUnit\Framework\TestCase;

class SimpleQueryStringQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new SimpleQueryStringQuery('"fried eggs" +(eggplant | potato) -frittata');
        $expected = [
            'simple_query_string' => [
                'query' => '"fried eggs" +(eggplant | potato) -frittata',
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
