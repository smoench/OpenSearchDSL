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
 * Class representing geo distance aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geodistance-aggregation.html
 */
class GeoDistanceAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private mixed $origin = null;
    private ?string $distanceType = null;
    private ?string $unit = null;
    private array $ranges = [];

    public function __construct(
        string $name,
        ?string $field = null,
        ?string $origin = null,
        array $ranges = [],
        ?string $unit = null,
        ?string $distanceType = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setOrigin($origin);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $this->addRange($from, $to);
        }
        $this->setUnit($unit);
        $this->setDistanceType($distanceType);
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDistanceType(): ?string
    {
        return $this->distanceType;
    }

    public function setDistanceType(?string $distanceType): self
    {
        $this->distanceType = $distanceType;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Add range to aggregation.
     *
     * @param int|float|null $from
     * @param int|float|null $to
     *
     * @return GeoDistanceAggregation
     * @throws LogicException
     *
     */
    public function addRange($from = null, $to = null)
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
            ],
        );

        if (empty($range)) {
            throw new LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    public function getArray(): array
    {
        $data = [];

        if ($this->getField() !== null) {
            $data['field'] = $this->getField();
        } else {
            throw new LogicException('Geo distance aggregation must have a field set.');
        }

        if ($this->getOrigin() !== null) {
            $data['origin'] = $this->getOrigin();
        } else {
            throw new LogicException('Geo distance aggregation must have an origin set.');
        }

        if ($this->getUnit() !== null) {
            $data['unit'] = $this->getUnit();
        }

        if ($this->getDistanceType() !== null) {
            $data['distance_type'] = $this->getDistanceType();
        }

        $data['ranges'] = $this->ranges;

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'geo_distance';
    }
}
