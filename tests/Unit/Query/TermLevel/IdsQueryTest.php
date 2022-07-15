<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\TermLevel;

use OpenSearchDSL\Query\TermLevel\IdsQuery;

class IdsQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new IdsQuery(['foo', 'bar']);
        $expected = [
            'ids' => [
                'values' => ['foo', 'bar'],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
