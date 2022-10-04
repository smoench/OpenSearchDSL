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

use OpenSearchDSL\Query\Span\FieldMaskingSpanQuery;
use OpenSearchDSL\Query\Span\SpanNearQuery;
use OpenSearchDSL\Query\Span\SpanTermQuery;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for FieldMaskingSpanQuery.
 */
class FieldMaskingSpanQueryTest extends TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray()
    {
        $spanTermQuery = new SpanTermQuery('text', 'quick brown');

        $spanTermQueryForMask = new SpanTermQuery('text.stems', 'fox');
        $fieldMaskingSpanQuery = new FieldMaskingSpanQuery('text', $spanTermQueryForMask);

        $spanNearQuery = new SpanNearQuery();
        $spanNearQuery->addQuery($spanTermQuery);
        $spanNearQuery->addQuery($fieldMaskingSpanQuery);
        $spanNearQuery->setSlop(5);
        $spanNearQuery->addParameter('in_order', false);

        $result = [
            'span_near' => [
                'clauses' => [
                    [
                        'span_term' => [
                            'text' => 'quick brown',
                        ],
                    ],
                    [
                        'field_masking_span' => [
                            'query' => [
                                'span_term' => [
                                    'text.stems' => 'fox',
                                ],
                            ],
                            'field' => 'text',
                        ],
                    ],
                ],
                'slop' => 5,
                'in_order' => false,
            ],
        ];

        $this->assertEquals($result, $spanNearQuery->toArray());
    }
}
