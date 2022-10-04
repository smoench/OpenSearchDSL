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
 * Class representing geo diversified sampler aggregation.
 *
 * @link https://goo.gl/yzXvqD
 */
class DiversifiedSamplerAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Defines how many results will be received from each shard
     */
    private ?int $shardSize;

    public function __construct(string $name, ?string $field = null, ?int $shardSize = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setShardSize($shardSize);
    }

    /**
     * @return mixed
     */
    public function getShardSize()
    {
        return $this->shardSize;
    }

    /**
     * @return $this
     */
    public function setShardSize(mixed $shardSize)
    {
        $this->shardSize = $shardSize;

        return $this;
    }

    public function getType(): string
    {
        return 'diversified_sampler';
    }

    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ]
        );
    }
}
