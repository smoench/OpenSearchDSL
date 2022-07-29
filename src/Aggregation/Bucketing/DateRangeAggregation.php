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

/**
 * Class representing date range aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html
 */
class DateRangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?string $format = null;

    private array $ranges = [];

    private bool $keyed = false;

    public function __construct(
        string $name,
        ?string $field = null,
        ?string $format = null,
        array $ranges = [],
        bool $keyed = false
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setFormat($format);
        $this->setKeyed($keyed);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $key = $range['key'] ?? null;
            $this->addRange($from, $to, $key);
        }
    }

    /**
     * Sets if result buckets should be keyed.
     *
     * @param bool $keyed
     *
     * @return DateRangeAggregation
     */
    public function setKeyed($keyed)
    {
        $this->keyed = $keyed;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Add range to aggregation.
     *
     * @param string|null $from
     * @param string|null $to
     * @param string|null $key
     *
     * @return $this
     *
     * @throws LogicException
     */
    public function addRange($from = null, $to = null, $key = null)
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
                'key' => $key,
            ],
            fn($v) => !is_null($v)
        );

        if (empty($range)) {
            throw new LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        if ($this->getField() && $this->getFormat() && !empty($this->ranges)) {
            return [
                'format' => $this->getFormat(),
                'field' => $this->getField(),
                'ranges' => $this->ranges,
                'keyed' => $this->keyed,
            ];
        }
        throw new LogicException('Date range aggregation must have field, format set and range added.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'date_range';
    }
}
