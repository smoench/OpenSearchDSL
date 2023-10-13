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

namespace OpenSearchDSL\Sort;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;
use stdClass;

/**
 * Holds all the values required for basic sorting.
 */
class FieldSort implements BuilderInterface
{
    use ParametersTrait;

    public const ASC = 'asc';

    public const DESC = 'desc';

    private ?BuilderInterface $nestedFilter = null;

    /**
     * @param array $params Params that can be set to field sort.
     */
    public function __construct(
        private string $field,
        private ?string $order = null,
        array $params = []
    ) {
        $this->setParameters($params);
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(string $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getNestedFilter(): ?BuilderInterface
    {
        return $this->nestedFilter;
    }

    public function setNestedFilter(BuilderInterface $nestedFilter): self
    {
        $this->nestedFilter = $nestedFilter;

        return $this;
    }

    public function getType(): string
    {
        return 'sort';
    }

    public function toArray(): array
    {
        if ($this->order !== null) {
            $this->addParameter('order', $this->order);
        }

        if ($this->nestedFilter instanceof \OpenSearchDSL\BuilderInterface) {
            $this->addParameter('nested', $this->nestedFilter->toArray());
        }

        return [
            $this->field => $this->getParameters() ?: new stdClass(),
        ];
    }
}
