<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Aggregation;

use OpenSearchDSL\BuilderBag;
use OpenSearchDSL\NameAwareTrait;
use OpenSearchDSL\NamedBuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * AbstractAggregation class.
 */
abstract class AbstractAggregation implements NamedBuilderInterface
{
    use ParametersTrait;
    use NameAwareTrait;

    private ?string $field = null;

    private ?BuilderBag $aggregations = null;

    abstract protected function supportsNesting(): bool;

    abstract public function getArray(): array|\stdClass;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function setField(?string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function addAggregation(AbstractAggregation $abstractAggregation): static
    {
        if ($this->aggregations === null) {
            $this->aggregations = $this->createBuilderBag();
        }

        $this->aggregations->add($abstractAggregation);
        
        return $this;
    }

    /**
     * Returns all sub aggregations.
     *
     * @return BuilderBag[]|NamedBuilderInterface[]
     */
    public function getAggregations(): array
    {
        if ($this->aggregations !== null) {
            return $this->aggregations->all();
        }

        return [];
    }

    /**
     * Returns sub aggregation.
     * @param string $name Aggregation name to return.
     *
     * @return AbstractAggregation|NamedBuilderInterface|null
     */
    public function getAggregation($name)
    {
        if ($this->aggregations && $this->aggregations->has($name)) {
            return $this->aggregations->get($name);
        }

        return null;
    }

    public function toArray(): array
    {
        $array = $this->getArray();
        $result = [
            $this->getType() => is_array($array) ? $this->processArray($array) : $array,
        ];

        if ($this->supportsNesting()) {
            $nestedResult = $this->collectNestedAggregations();

            if (!empty($nestedResult)) {
                $result['aggregations'] = $nestedResult;
            }
        }

        return $result;
    }

    /**
     * Process all nested aggregations.
     *
     * @return array
     */
    protected function collectNestedAggregations()
    {
        $result = [];
        /** @var AbstractAggregation $aggregation */
        foreach ($this->getAggregations() as $aggregation) {
            $result[$aggregation->getName()] = $aggregation->toArray() ?: null;
        }

        return $result;
    }

    private function createBuilderBag(): BuilderBag
    {
        return new BuilderBag();
    }
}
