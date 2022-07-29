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

use OpenSearchDSL\Query\Span\SpanContainingQuery;
use OpenSearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for SpanContainingQuery.
 */
class SpanContainingQueryTest extends TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray()
    {
        $query = new SpanContainingQuery(
            $this->getSpanQueryMock('foo'),
            $this->getSpanQueryMock('bar')
        );
        $result = [
            'span_containing' => [
                'little' => [
                    'span_term' => ['user' => 'foo'],
                ],
                'big' => [
                    'span_term' => ['user' => 'bar'],
                ],
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }

    /**
     * @param string $value
     *
     * @returns MockObject
     */
    private function getSpanQueryMock($value)
    {
        $mock = $this->getMockBuilder(SpanQueryInterface::class)->getMock();
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['span_term' => ['user' => $value]]);
        return $mock;
    }
}
