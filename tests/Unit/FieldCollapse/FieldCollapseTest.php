<?php

declare(strict_types=1);

namespace OpenSearchDSL\Tests\Unit\FieldCollapse;

use OpenSearchDSL\FieldCollapse\FieldCollapse;
use OpenSearchDSL\FieldCollapse\InnerHits;
use PHPUnit\Framework\TestCase;

class FieldCollapseTest extends TestCase
{
    public function testGetType(): void
    {
        $this->assertEquals('collapse', (new FieldCollapse('test'))->getType());
    }

    public function testTraitHasParameter(): void
    {
        $collapse = new FieldCollapse('test');
        $collapse->addParameter('max_concurrent_group_searches', 4);

        $this->assertTrue($collapse->hasParameter('max_concurrent_group_searches'));
    }

    public function testTraitRemoveParameter(): void
    {
        $collapse = new FieldCollapse('test');
        $collapse->addParameter('max_concurrent_group_searches', 4);
        $collapse->removeParameter('max_concurrent_group_searches');

        $this->assertFalse($collapse->hasParameter('max_concurrent_group_searches'));
    }

    public function testTraitGetParameter(): void
    {
        $collapse = new FieldCollapse('test');
        $collapse->addParameter('max_concurrent_group_searches', 4);

        $this->assertEquals(4, $collapse->getParameter('max_concurrent_group_searches'));
    }

    public function testTraitSetGetParameters(): void
    {
        $collapse = new FieldCollapse('test');
        $collapse->setParameters([
            'max_concurrent_group_searches' => 4,
        ]);

        $this->assertEquals([
            'max_concurrent_group_searches' => 4,
        ], $collapse->getParameters());
    }

    public function testToArray(): void
    {
        $collapse = new FieldCollapse('test');
        $collapse->addParameter('max_concurrent_group_searches', 4);
        $collapse->addInnerHits(new InnerHits('test_1'));
        $collapse->addInnerHits(new InnerHits('test_2'));

        $expectedResult = [
            'field' => 'test',
            'max_concurrent_group_searches' => 4,
            'inner_hits' => [
                [
                    'name' => 'test_1',
                ],
                [
                    'name' => 'test_2',
                ],
            ],
        ];
        $this->assertEquals($expectedResult, $collapse->toArray());
    }
}
