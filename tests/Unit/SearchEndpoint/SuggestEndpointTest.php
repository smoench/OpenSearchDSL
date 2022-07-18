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

use OpenSearchDSL\SearchEndpoint\SuggestEndpoint;
use OpenSearchDSL\Suggest\Suggest;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SuggestEndpointTest extends TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(SuggestEndpoint::class, new SuggestEndpoint());
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $suggestName = 'acme_suggest';
        $text = 'foo';
        $suggest = new Suggest($suggestName, 'text', $text, 'acme');
        $endpoint = new SuggestEndpoint();
        $endpoint->add($suggest, $suggestName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($suggest, $builders[$suggestName]);
    }

    /**
     * Tests endpoint normalization.
     */
    public function testNormalize()
    {
        $instance = new SuggestEndpoint();

        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class
        );

        $suggest = new Suggest('foo', 'bar', 'acme', 'foo');
        $instance->add($suggest);

        $this->assertEquals(
            $suggest->toArray(),
            $instance->normalize($normalizerInterface)
        );
    }
}
