<?php

declare(strict_types=1);

namespace OpenSearchDSL\Tests\Unit\SearchEndpoint;

use OpenSearchDSL\FieldCollapse\FieldCollapse;
use OpenSearchDSL\SearchEndpoint\CollapseEndpoint;
use PHPUnit\Framework\TestCase;

class CollapseEndpointTest extends TestCase
{
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(CollapseEndpoint::class, new CollapseEndpoint());
    }

    public function testNormalization(): void
    {
        $instance = new CollapseEndpoint();

        $this->assertNull($instance->normalize());

        $collapse = new FieldCollapse('acme');
        $instance->add($collapse);

        $this->assertEquals(
            json_encode($collapse->toArray(), JSON_THROW_ON_ERROR),
            json_encode($instance->normalize(), JSON_THROW_ON_ERROR)
        );
    }

    public function testEndpointGetter(): void
    {
        $collapseName = 'acme_collapse';
        $collapse = new FieldCollapse('acme');

        $endpoint = new CollapseEndpoint();
        $endpoint->add($collapse, $collapseName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($collapse, $builders[$collapseName]);
    }
}
