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

use OpenSearchDSL\Query\Span\SpanFirstQuery;
use OpenSearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for SpanFirstQuery.
 */
class SpanFirstQueryTest extends TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray()
    {
        $mock = $this->getMockBuilder(SpanQueryInterface::class)->getMock();
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['span_term' => ['user' => 'bob']]);

        $query = new SpanFirstQuery($mock, 5);
        $result = [
            'span_first' => [
                'match' => [
                    'span_term' => ['user' => 'bob'],
                ],
                'end' => 5,
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }
}
