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

namespace OpenSearchDSL\Tests\Unit\Query\TermLevel;

use OpenSearchDSL\Query\TermLevel\RangeQuery;
use PHPUnit\Framework\TestCase;

class RangeQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new RangeQuery('age', [
            'gte' => 10,
            'lte' => 20,
        ]);
        $expected = [
            'range' => [
                'age' => [
                    'gte' => 10,
                    'lte' => 20,
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
