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
use OpenSearchDSL\BuilderInterface;

/**
 * Class representing composite aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class CompositeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var BuilderInterface[]
     */
    private array $sources = [];

    private ?int $size = null;

    private array $after = [];

    /**
     * @param AbstractAggregation[] $sources
     */
    public function __construct(string $name, array $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    /**
     * @throws LogicException
     */
    public function addSource(AbstractAggregation $agg): self
    {
        $array = $agg->getArray();

        $array = is_array($array) ? array_merge($array, $agg->getParameters()) : $array;

        $this->sources[] = [
            $agg->getName() => [
                $agg->getType() => $array,
            ],
        ];

        return $this;
    }

    public function getArray(): array
    {
        $array = [
            'sources' => $this->sources,
        ];

        if ($this->size !== null) {
            $array['size'] = $this->size;
        }

        if ($this->after !== []) {
            $array['after'] = $this->after;
        }

        return $array;
    }

    public function getType(): string
    {
        return 'composite';
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setAfter(array $after): self
    {
        $this->after = $after;

        return $this;
    }

    public function getAfter(): array
    {
        return $this->after;
    }
}
