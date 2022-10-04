<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\SearchEndpoint;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search post filter dsl endpoint.
 */
class PostFilterEndpoint extends QueryEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'post_filter';

    public function normalize(
        NormalizerInterface $normalizer,
        $format = null,
        array $context = []
    ): array|string|int|float|bool {
        if ($this->getBool() === null) {
            return false;
        }

        return $this->getBool()->toArray();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
