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

use OpenSearchDSL\Query\TermLevel\WildcardQuery;
use PHPUnit\Framework\TestCase;

class WildcardQueryTest extends TestCase
{
    /**
     * Test for query toArray() method.
     */
    public function testToArray()
    {
        $query = new WildcardQuery('user', 'ki*y');
        $expectedResult = [
            'wildcard' => [
                'user' => [
                    'value' => 'ki*y',
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $query->toArray());
    }
}
