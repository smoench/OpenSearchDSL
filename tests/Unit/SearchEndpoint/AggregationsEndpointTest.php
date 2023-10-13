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

use OpenSearchDSL\Aggregation\Bucketing\MissingAggregation;
use OpenSearchDSL\SearchEndpoint\AggregationsEndpoint;
use PHPUnit\Framework\TestCase;

class AggregationsEndpointTest extends TestCase
{
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(
            AggregationsEndpoint::class,
            new AggregationsEndpoint()
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $aggName = 'acme_agg';
        $agg = new MissingAggregation('acme');
        $endpoint = new AggregationsEndpoint();
        $endpoint->add($agg, $aggName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($agg, $builders[$aggName]);
    }
}
