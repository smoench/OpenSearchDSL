<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit;

use OpenSearchDSL\Search;
use PHPUnit\Framework\TestCase;

/**
 * Test for Search.
 */
class SearchTest extends TestCase
{
    /**
     * Tests Search constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(Search::class, new Search());
    }

    public function testScrollUriParameter()
    {
        $search = new Search();
        $search->setScroll('5m');

        $this->assertArrayHasKey('scroll', $search->getUriParams());
    }
}
