<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Aggregation\Bucketing;

use LogicException;
use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\BucketingTrait;
use stdClass;

/**
 * Class representing GlobalAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-global-aggregation.html
 */
class GlobalAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function setField($field): static
    {
        throw new LogicException("Global aggregation, doesn't support `field` parameter");
    }

    public function getType(): string
    {
        return 'global';
    }

    public function getArray(): stdClass
    {
        return new stdClass();
    }
}
