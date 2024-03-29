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

namespace OpenSearchDSL\Tests\Unit\SearchEndpoint;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\NamedBuilderInterface;
use OpenSearchDSL\SearchEndpoint\InnerHitsEndpoint;
use PHPUnit\Framework\TestCase;

class InnerHitsEndpointTest extends TestCase
{
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(
            InnerHitsEndpoint::class,
            new InnerHitsEndpoint()
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $hitName = 'foo';
        $innerHit = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, $hitName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($innerHit, $builders[$hitName]);
    }

    /**
     * Tests normalize method
     */
    public function testNormalization()
    {
        $innerHit = $this
            ->getMockBuilder(NamedBuilderInterface::class)
            ->onlyMethods(['getName', 'toArray', 'getType'])
            ->getMock();
        $innerHit->expects($this->any())->method('getName')->willReturn('foo');
        $innerHit->expects($this->any())->method('toArray')->willReturn([
            'foo' => 'bar',
        ]);

        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, 'foo');
        $expected = [
            'foo' => [
                'foo' => 'bar',
            ],
        ];

        $this->assertEquals(
            $expected,
            $endpoint->normalize()
        );
    }
}
