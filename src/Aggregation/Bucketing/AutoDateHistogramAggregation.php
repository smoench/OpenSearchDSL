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
 * Class representing AutoDateHistogramAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-autodatehistogram-aggregation.html
 */
class AutoDateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(string $name, string $field, ?int $buckets = null, ?string $format = null)
    {
        parent::__construct($name);

        $this->setField($field);

        if ($buckets) {
            $this->addParameter('buckets', $buckets);
        }

        if ($format) {
            $this->addParameter('format', $format);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'auto_date_histogram';
    }
}
