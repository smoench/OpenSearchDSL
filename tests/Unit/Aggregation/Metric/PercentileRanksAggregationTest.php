<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Metric\Aggregation;

use LogicException;
use OpenSearchDSL\Aggregation\Metric\PercentileRanksAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Percentile ranks aggregation unit tests.
 */
class PercentileRanksAggregationTest extends TestCase
{
    /**
     * @var PercentileRanksAggregation
     */
    public $agg;

    /**
     * Phpunit setup.
     */
    protected function setUp(): void
    {
        $this->agg = new PercentileRanksAggregation('foo');
    }

    /**
     * Tests if exception is thrown when required parameters not set.
     */
    public function testIfPercentileRanksAggregationThrowsAnException()
    {
        $this->expectException(LogicException::class);
        $this->agg->toArray();
    }

    /**
     * Tests exception when only field is set.
     */
    public function testIfExceptionIsThrownWhenFieldSetAndValueNotSet()
    {
        $this->expectException(LogicException::class);
        $this->agg->setField('bar');
        $this->agg->toArray();
    }

    /**
     * Tests exception when only value is set.
     */
    public function testIfExceptionIsThrownWhenScriptSetAndValueNotSet()
    {
        $this->expectException(LogicException::class);
        $this->agg->setScript('bar');
        $this->agg->toArray();
    }

    /**
     * Test getType method.
     */
    public function testGetType()
    {
        $this->assertEquals('percentile_ranks', $this->agg->getType());
    }

    /**
     * Test toArray method.
     */
    public function testToArray()
    {
        $this->agg->setField('bar');
        $this->agg->setValues(['bar']);
        $this->assertSame(
            [
                'percentile_ranks' => [
                    'field' => 'bar',
                    'values' => ['bar'],
                ],
            ],
            $this->agg->toArray()
        );
    }
}
