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
use stdClass;

/**
 * Class representing ReverseNestedAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-reverse-nested-aggregation.html
 */
class ReverseNestedAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?string $path = null;

    public function __construct(string $name, ?string $path = null)
    {
        parent::__construct($name);

        $this->setPath($path);
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getType(): string
    {
        return 'reverse_nested';
    }

    public function getArray(): array|stdClass
    {
        $output = new stdClass();
        if ($this->getPath() !== null) {
            $output = ['path' => $this->getPath()];
        }

        return $output;
    }
}
