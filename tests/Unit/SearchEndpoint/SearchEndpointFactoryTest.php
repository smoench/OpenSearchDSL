<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Unit\SearchEndpoint;

use OpenSearchDSL\SearchEndpoint\AggregationsEndpoint;
use OpenSearchDSL\SearchEndpoint\SearchEndpointFactory;
use OpenSearchDSL\SearchEndpoint\SearchEndpointInterface;

/**
 * Unit test class for search endpoint factory.
 */
class SearchEndpointFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests get method exception.
     *
     * @expectedException \RuntimeException
     */
    public function testGet()
    {
        SearchEndpointFactory::get('foo');
    }

    /**
     * Tests if factory can create endpoint.
     */
    public function testFactory()
    {
        $endpoinnt = SearchEndpointFactory::get(AggregationsEndpoint::NAME);

        $this->assertInstanceOf(SearchEndpointInterface::class, $endpoinnt);
    }
}
