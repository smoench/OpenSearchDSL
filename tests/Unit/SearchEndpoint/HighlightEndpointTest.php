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

use OpenSearchDSL\Highlight\Highlight;
use OpenSearchDSL\SearchEndpoint\HighlightEndpoint;
use PHPUnit\Framework\TestCase;

class HighlightEndpointTest extends TestCase
{
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(HighlightEndpoint::class, new HighlightEndpoint());
    }

    /**
     * Tests adding builder.
     */
    public function testNormalization()
    {
        $instance = new HighlightEndpoint();

        $this->assertNull($instance->normalize());

        $highlight = new Highlight();
        $highlight->addField('acme');
        $instance->add($highlight);

        $this->assertEquals(
            json_encode($highlight->toArray(), JSON_THROW_ON_ERROR),
            json_encode($instance->normalize(), JSON_THROW_ON_ERROR)
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $highlightName = 'acme_highlight';
        $highlight = new Highlight();
        $highlight->addField('acme');

        $endpoint = new HighlightEndpoint();
        $endpoint->add($highlight, $highlightName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($highlight, $builders[$highlightName]);
    }
}
