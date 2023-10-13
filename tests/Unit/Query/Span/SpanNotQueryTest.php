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

namespace OpenSearchDSL\Tests\Unit\Query\Span;

use OpenSearchDSL\Query\Span\SpanNotQuery;
use OpenSearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for SpanNotQuery.
 */
class SpanNotQueryTest extends TestCase
{
    /**
     * Tests for toArray().
     */
    public function testSpanNotQueryToArray()
    {
        $mock = $this->getMockBuilder(SpanQueryInterface::class)->getMock();
        $mock
            ->expects($this->exactly(2))
            ->method('toArray')
            ->willReturn([
                'span_term' => [
                    'key' => 'value',
                ],
            ]);

        $query = new SpanNotQuery($mock, $mock);
        $result = [
            'span_not' => [
                'include' => [
                    'span_term' => [
                        'key' => 'value',
                    ],
                ],
                'exclude' => [
                    'span_term' => [
                        'key' => 'value',
                    ],
                ],
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }
}
