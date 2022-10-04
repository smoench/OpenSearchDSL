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

use OpenSearchDSL\Aggregation\Bucketing\SamplerAggregation;
use OpenSearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class SamplerAggregationTest extends TestCase
{
    /**
     * Tests getType method.
     */
    public function testGetType()
    {
        $aggregation = new SamplerAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('sampler', $result);
    }

    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new SamplerAggregation('foo');
        $aggregation->addAggregation($termAggregation);
        $aggregation->setField('name');
        $aggregation->setShardSize(200);
        $result = $aggregation->toArray();
        $expected = [
            'sampler' => [
                'field' => 'name',
                'shard_size' => 200,
            ],
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method without provided shard size.
     */
    public function testGetArrayNoShardSize()
    {
        $aggregation = new SamplerAggregation('foo', 'bar');
        $this->assertEquals([
            'field' => 'bar',
        ], $aggregation->getArray());
    }
}
