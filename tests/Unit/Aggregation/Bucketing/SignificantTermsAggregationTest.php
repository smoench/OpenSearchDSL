<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Bucketing\Aggregation;

use OpenSearchDSL\Aggregation\Bucketing\SignificantTermsAggregation;

/**
 * Unit test for children aggregation.
 */
class SignificantTermsAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests getType method.
     */
    public function testSignificantTermsAggregationGetType()
    {
        $aggregation = new SignificantTermsAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('significant_terms', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testSignificantTermsAggregationGetArray()
    {
        $mock = $this->getMockBuilder('OpenSearchDSL\Aggregation\AbstractAggregation')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $aggregation = new SignificantTermsAggregation('foo', 'title');
        $aggregation->addAggregation($mock);
        $result = $aggregation->getArray();
        $expected = ['field' => 'title'];
        $this->assertEquals($expected, $result);
    }
}
