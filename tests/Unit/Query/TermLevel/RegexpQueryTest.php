<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use ONGR\ElasticsearchDSL\Query\TermLevel\RegexpQuery;
use PHPUnit\Framework\TestCase;

class RegexpQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new RegexpQuery('user', 's.*y');
        $expected = [
            'regexp' => [
                'user' => [
                    'value' => 's.*y',
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
