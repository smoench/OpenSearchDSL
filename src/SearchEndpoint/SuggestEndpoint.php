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
 * Search suggest dsl endpoint.
 */
class SuggestEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    final public const NAME = 'suggest';

    public function normalize(): ?array
    {
        $output = [];
        if ($this->getAll() !== []) {
            foreach ($this->getAll() as $suggest) {
                $output = array_merge($output, $suggest->toArray());
            }
        }

        return $output;
    }
}
