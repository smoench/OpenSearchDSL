<?php

namespace OpenSearchDSL\Aggregation\Pipeline;

use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\MetricTrait;

abstract class AbstractPipelineAggregation extends AbstractAggregation
{
    use MetricTrait;

    private string|array|null $bucketsPath = null;

    public function __construct(string $name, string|array|null $bucketsPath = null)
    {
        parent::__construct($name);
        $this->setBucketsPath($bucketsPath);
    }

    public function getBucketsPath(): string|array|null
    {
        return $this->bucketsPath;
    }

    public function setBucketsPath(string|array|null $bucketsPath): self
    {
        $this->bucketsPath = $bucketsPath;

        return $this;
    }

    public function getArray(): array
    {
        return ['buckets_path' => $this->getBucketsPath()];
    }
}
