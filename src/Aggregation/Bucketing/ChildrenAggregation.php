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
 * Class representing ChildrenAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-children-aggregation.html
 */
class ChildrenAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?string $children;

    public function __construct(string $name, ?string $children = null)
    {
        parent::__construct($name);

        $this->setChildren($children);
    }

    public function getChildren(): ?string
    {
        return $this->children;
    }

    public function setChildren(?string $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getType(): string
    {
        return 'children';
    }

    public function getArray(): array
    {
        if (count($this->getAggregations()) === 0) {
            throw new LogicException("Children aggregation `{$this->getName()}` has no aggregations added");
        }

        return [
            'type' => $this->getChildren(),
        ];
    }
}
