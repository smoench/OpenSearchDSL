<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\Span;

use OpenSearchDSL\Query\Span\SpanNearQuery;

/**
 * Unit test for SpanNearQuery.
 */
class SpanNearQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray()
    {
        $mock = $this->getMockBuilder('OpenSearchDSL\Query\Span\SpanQueryInterface')->getMock();
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['span_term' => ['key' => 'value']]);

        $query = new SpanNearQuery(['in_order' => false]);
        $query->setSlop(5);
        $query->addQuery($mock);
        $result = [
            'span_near' => [
                'clauses' => [
                    0 => [
                        'span_term' => [
                            'key' => 'value',
                        ],
                    ],
                ],
                'slop' => 5,
                'in_order' => false,
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }
}
