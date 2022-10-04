<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\Compound;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\Query\Compound\ConstantScoreQuery;
use PHPUnit\Framework\TestCase;

class ConstantScoreQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $mock = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $mock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn([
                'term' => [
                    'foo' => 'bar',
                ],
            ]);

        $query = new ConstantScoreQuery($mock, [
            'boost' => 1.2,
        ]);
        $expected = [
            'constant_score' => [
                'filter' => [
                    'term' => [
                        'foo' => 'bar',
                    ],
                ],
                'boost' => 1.2,
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
