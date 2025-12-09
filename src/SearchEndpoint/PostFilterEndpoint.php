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
 * Search post filter dsl endpoint.
 */
class PostFilterEndpoint extends QueryEndpoint
{
    /**
     * Endpoint name
     */
    final public const NAME = 'post_filter';

    #[\Override]
    public function normalize(): ?array
    {
        return $this->getBool()?->toArray();
    }

    #[\Override]
    public function getOrder(): int
    {
        return 1;
    }
}
