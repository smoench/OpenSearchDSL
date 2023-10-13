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

namespace OpenSearchDSL\Aggregation\Bucketing;

use LogicException;
use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing Histogram aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html
 */
class HistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public const DIRECTION_ASC = 'asc';

    public const DIRECTION_DESC = 'desc';

    private ?int $interval = null;

    private ?int $minDocCount = null;

    private ?array $extendedBounds = null;

    private ?string $orderMode = null;

    private string $orderDirection;

    private ?bool $keyed = null;

    public function __construct(
        string $name,
        ?string $field = null,
        ?int $interval = null,
        ?int $minDocCount = null,
        ?string $orderMode = null,
        string $orderDirection = self::DIRECTION_ASC,
        ?int $extendedBoundsMin = null,
        ?int $extendedBoundsMax = null,
        ?bool $keyed = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setInterval($interval);
        $this->setMinDocCount($minDocCount);
        $this->setOrder($orderMode, $orderDirection);
        $this->setExtendedBounds($extendedBoundsMin, $extendedBoundsMax);
        $this->setKeyed($keyed);
    }

    public function isKeyed(): ?bool
    {
        return $this->keyed;
    }

    /**
     * Get response as a hash instead keyed by the buckets keys.
     */
    public function setKeyed(?bool $keyed): self
    {
        $this->keyed = $keyed;

        return $this;
    }

    /**
     * Sets buckets ordering.
     */
    public function setOrder(?string $mode, ?string $direction = self::DIRECTION_ASC): self
    {
        $this->orderMode = $mode;
        $this->orderDirection = $direction;

        return $this;
    }

    public function getOrder(): ?array
    {
        if ($this->orderMode && $this->orderDirection) {
            return [
                $this->orderMode => $this->orderDirection,
            ];
        }

        return null;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(?int $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function getMinDocCount(): ?int
    {
        return $this->minDocCount;
    }

    /**
     * Set limit for document count buckets should have.
     */
    public function setMinDocCount(?int $minDocCount): self
    {
        $this->minDocCount = $minDocCount;

        return $this;
    }

    public function getExtendedBounds(): array
    {
        return $this->extendedBounds;
    }

    public function setExtendedBounds(?int $min = null, ?int $max = null): self
    {
        $bounds = array_filter(
            [
                'min' => $min,
                'max' => $max,
            ],
        );
        $this->extendedBounds = $bounds;

        return $this;
    }

    public function getType(): string
    {
        return 'histogram';
    }

    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'interval' => $this->getInterval(),
                'min_doc_count' => $this->getMinDocCount(),
                'extended_bounds' => $this->getExtendedBounds(),
                'keyed' => $this->isKeyed(),
                'order' => $this->getOrder(),
            ],
            fn ($val) => $val || is_numeric($val)
        );
        $this->checkRequiredParameters($out, ['field', 'interval']);

        return $out;
    }

    /**
     * Checks if all required parameters are set.
     *
     * @throws LogicException
     */
    protected function checkRequiredParameters(array $data, array $required): void
    {
        if (count(array_intersect_key(array_flip($required), $data)) !== count($required)) {
            throw new LogicException('Histogram aggregation must have field and interval set.');
        }
    }
}
