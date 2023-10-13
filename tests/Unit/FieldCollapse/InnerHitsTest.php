<?php

declare(strict_types=1);

namespace OpenSearchDSL\Tests\Unit\FieldCollapse;

use OpenSearchDSL\FieldCollapse\FieldCollapse;
use OpenSearchDSL\FieldCollapse\InnerHits;
use PHPUnit\Framework\TestCase;

class InnerHitsTest extends TestCase
{
    public function testGetType(): void
    {
        $this->assertEquals('inner_hits', (new InnerHits('test'))->getType());
    }

    public function testTraitHasParameter(): void
    {
        $innerHits = new InnerHits('test');
        $innerHits->addParameter('size', 4);

        $this->assertTrue($innerHits->hasParameter('size'));
    }

    public function testTraitRemoveParameter(): void
    {
        $innerHits = new InnerHits('test');
        $innerHits->addParameter('size', 4);
        $innerHits->removeParameter('size');

        $this->assertFalse($innerHits->hasParameter('size'));
    }

    public function testTraitGetParameter(): void
    {
        $innerHits = new InnerHits('test');
        $innerHits->addParameter('size', 4);

        $this->assertEquals(4, $innerHits->getParameter('size'));
    }

    public function testTraitSetGetParameters(): void
    {
        $innerHits = new InnerHits('test');
        $innerHits->setParameters([
            'size' => 4,
        ]);

        $this->assertEquals([
            'size' => 4,
        ], $innerHits->getParameters());
    }

    public function testToArray(): void
    {
        $innerHits = new InnerHits('test');
        $innerHits->addParameter('size', 4);
        $innerHits->setFieldCollapse(new FieldCollapse('test'));

        $expectedResult = [
            'name' => 'test',
            'size' => 4,
            'collapse' => [
                'field' => 'test',
            ],
        ];
        $this->assertEquals($expectedResult, $innerHits->toArray());
    }
}
