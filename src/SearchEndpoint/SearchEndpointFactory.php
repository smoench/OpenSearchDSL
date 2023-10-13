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

namespace OpenSearchDSL\SearchEndpoint;

use RuntimeException;

/**
 * Factory for search endpoints.
 */
class SearchEndpointFactory
{
    private static array $endpoints = [
        QueryEndpoint::NAME => QueryEndpoint::class,
        PostFilterEndpoint::NAME => PostFilterEndpoint::class,
        SortEndpoint::NAME => SortEndpoint::class,
        HighlightEndpoint::NAME => HighlightEndpoint::class,
        AggregationsEndpoint::NAME => AggregationsEndpoint::class,
        SuggestEndpoint::NAME => SuggestEndpoint::class,
        InnerHitsEndpoint::NAME => InnerHitsEndpoint::class,
        CollapseEndpoint::NAME => CollapseEndpoint::class,
    ];

    /**
     * Returns a search endpoint instance.
     *
     * @param string $type Type of endpoint.
     *
     * @throws RuntimeException Endpoint does not exist.
     */
    public static function get(string $type): SearchEndpointInterface
    {
        if (! array_key_exists($type, self::$endpoints)) {
            throw new RuntimeException('Endpoint does not exist.');
        }

        return new self::$endpoints[$type]();
    }
}
