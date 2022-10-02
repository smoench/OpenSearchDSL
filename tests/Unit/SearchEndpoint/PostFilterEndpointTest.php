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
use OpenSearchDSL\SearchEndpoint\PostFilterEndpoint;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class PostFilterEndpointTest.
 */
class PostFilterEndpointTest extends TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(PostFilterEndpoint::class, new PostFilterEndpoint());
    }

    /**
     * Tests if correct order is returned. It's very important that filters must be executed second.
     */
    public function testGetOrder()
    {
        $instance = new PostFilterEndpoint();
        $this->assertEquals(1, $instance->getOrder());
    }

    /**
     * Test normalization.
     */
    public function testNormalization()
    {
        $instance = new PostFilterEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class
        );
        $this->assertFalse($instance->normalize($normalizerInterface));

        $matchAll = new MatchAllQuery();
        $instance->add($matchAll);

        $this->assertEquals(
            json_encode($matchAll->toArray(), JSON_THROW_ON_ERROR),
            json_encode($instance->normalize($normalizerInterface), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $filterName = 'acme_post_filter';
        $filter = new MatchAllQuery();

        $endpoint = new PostFilterEndpoint();
        $endpoint->add($filter, $filterName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($filter, $builders[$filterName]);
    }
}
