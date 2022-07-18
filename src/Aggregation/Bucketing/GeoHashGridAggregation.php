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
 * Class representing geohash grid aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geohashgrid-aggregation.html
 */
class GeoHashGridAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?int $precision = null;
    private ?int $size = null;
    private ?int $shardSize = null;

    public function __construct(
        string $name,
        ?string $field = null,
        ?int $precision = null,
        ?int $size = null,
        ?int $shardSize = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setPrecision($precision);
        $this->setSize($size);
        $this->setShardSize($shardSize);
    }

    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    public function setPrecision(?int $precision): self
    {
        $this->precision = $precision;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getShardSize(): ?int
    {
        return $this->shardSize;
    }

    public function setShardSize(?int $shardSize): self
    {
        $this->shardSize = $shardSize;

        return $this;
    }

    public function getArray(): array
    {
        $data = [];

        if ($this->getField() !== null) {
            $data['field'] = $this->getField();
        } else {
            throw new LogicException('Geo bounds aggregation must have a field set.');
        }

        if ($this->getPrecision() !== null) {
            $data['precision'] = $this->getPrecision();
        }

        if ($this->getSize() !== null) {
            $data['size'] = $this->getSize();
        }

        if ($this->getShardSize() !== null) {
            $data['shard_size'] = $this->getShardSize();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'geohash_grid';
    }
}
