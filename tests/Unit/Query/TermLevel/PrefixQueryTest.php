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

use OpenSearchDSL\Query\TermLevel\PrefixQuery;
use PHPUnit\Framework\TestCase;

class PrefixQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new PrefixQuery('user', 'ki');
        $expected = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
