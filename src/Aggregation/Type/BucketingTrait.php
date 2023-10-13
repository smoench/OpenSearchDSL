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

namespace OpenSearchDSL\Aggregation\Type;

/**
 * Trait used by Aggregations which supports nesting.
 */
trait BucketingTrait
{
    /**
     * Bucketing aggregations supports nesting.
     */
    protected function supportsNesting(): bool
    {
        return true;
    }
}
