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

use OpenSearchDSL\Query\Span\SpanMultiTermQuery;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for SpanMultiTermQuery.
 */
class SpanMultiTermQueryTest extends TestCase
{
    /**
     * Test for toArray().
     */
    public function testToArray()
    {
        $mock = $this->getMockBuilder('OpenSearchDSL\BuilderInterface')->getMock();
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['prefix' => ['user' => ['value' => 'ki']]]);

        $query = new SpanMultiTermQuery($mock);
        $expected = [
            'span_multi' => [
                'match' => [
                    'prefix' => ['user' => ['value' => 'ki']],
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
