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

/**
 * Search sort dsl endpoint.
 */
class SortEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'sort';

    public function normalize(): ?array
    {
        $output = [];

        foreach ($this->getAll() as $sort) {
            $output[] = $sort->toArray();
        }

        return $output;
    }
}
