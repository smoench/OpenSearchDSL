<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Aggregation\Bucketing;

use OpenSearchDSL\Aggregation\Bucketing\SignificantTextAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class SignificantTextAggregationTest extends TestCase
{
    /**
     * Tests getType method.
     */
    public function testSignificantTextAggregationGetType()
    {
        $aggregation = new SignificantTextAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('significant_text', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testSignificantTermsAggregationGetArray()
    {
        $mock = $this->getMockBuilder('OpenSearchDSL\Aggregation\AbstractAggregation')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $aggregation = new SignificantTextAggregation('foo', 'title');
        $aggregation->addAggregation($mock);
        $result = $aggregation->getArray();
        $expected = ['field' => 'title'];
        $this->assertEquals($expected, $result);
    }
}
