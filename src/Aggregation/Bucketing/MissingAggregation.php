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

use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing missing aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-missing-aggregation.html
 */
class MissingAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     */
    public function __construct($name, $field = null)
    {
        parent::__construct($name);

        $this->setField($field);
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if ($this->getField()) {
            return ['field' => $this->getField()];
        }
        throw new \LogicException('Missing aggregation must have a field set.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'missing';
    }
}
