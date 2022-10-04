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

use OpenSearchDSL\Query\MatchAllQuery;
use OpenSearchDSL\SearchEndpoint\QueryEndpoint;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Unit test class for the QueryEndpoint.
 */
class QueryEndpointTest extends TestCase
{
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(QueryEndpoint::class, new QueryEndpoint());
    }

    /**
     * Tests if correct order is returned. Query must be executed after filter and post filter.
     */
    public function testGetOrder()
    {
        $instance = new QueryEndpoint();
        $this->assertEquals(2, $instance->getOrder());
    }

    /**
     * Tests if endpoint return correct normalized data.
     */
    public function testEndpoint()
    {
        $instance = new QueryEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class
        );

        $this->assertFalse($instance->normalize($normalizerInterface));

        $matchAll = new MatchAllQuery();
        $instance->add($matchAll);

        $this->assertEquals(
            $matchAll->toArray(),
            $instance->normalize($normalizerInterface)
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $queryName = 'acme_query';
        $query = new MatchAllQuery();
        $endpoint = new QueryEndpoint();
        $endpoint->add($query, $queryName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($query, $builders[$queryName]);
    }
}
