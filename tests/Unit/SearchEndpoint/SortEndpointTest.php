<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\SearchEndpoint;

use OpenSearchDSL\SearchEndpoint\SortEndpoint;
use OpenSearchDSL\Sort\FieldSort;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SortEndpointTest.
 */
class SortEndpointTest extends TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('OpenSearchDSL\SearchEndpoint\SortEndpoint', new SortEndpoint());
    }

    /**
     * Tests endpoint normalization.
     */
    public function testNormalize()
    {
        $instance = new SortEndpoint();

        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );

        $sort = new FieldSort('acme', ['order' => FieldSort::ASC]);
        $instance->add($sort);

        $this->assertEquals(
            [$sort->toArray()],
            $instance->normalize($normalizerInterface)
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $sortName = 'acme_sort';
        $sort = new FieldSort('acme');
        $endpoint = new SortEndpoint();
        $endpoint->add($sort, $sortName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($sort, $builders[$sortName]);
    }
}
