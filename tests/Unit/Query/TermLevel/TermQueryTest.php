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

use OpenSearchDSL\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class TermQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new TermQuery('user', 'bob');
        $expected = [
            'term' => [
                'user' => 'bob',
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
