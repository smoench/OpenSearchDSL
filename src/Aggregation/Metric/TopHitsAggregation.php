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

namespace OpenSearchDSL\Aggregation\Metric;

use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\MetricTrait;
use OpenSearchDSL\BuilderInterface;
use stdClass;

/**
 * Top hits aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-top-hits-aggregation.html
 */
class TopHitsAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var int|null Number of top matching hits to return per bucket.
     */
    private ?int $size;

    /**
     * @var int|null The offset from the first result you want to fetch.
     */
    private ?int $from;

    /**
     * @var BuilderInterface[] How the top matching hits should be sorted.
     */
    private array $sorts = [];

    /**
     * @param string                $name Aggregation name.
     * @param null|int              $size Number of top matching hits to return per bucket.
     * @param null|int              $from The offset from the first result you want to fetch.
     * @param null|BuilderInterface $sort How the top matching hits should be sorted.
     */
    public function __construct(string $name, ?int $size = null, ?int $from = null, ?BuilderInterface $sort = null)
    {
        parent::__construct($name);

        $this->setSize($size);
        $this->setFrom($from);

        if ($sort instanceof \OpenSearchDSL\BuilderInterface) {
            $this->addSort($sort);
        }
    }

    public function getFrom(): ?int
    {
        return $this->from;
    }

    public function setFrom(?int $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return BuilderInterface[]
     */
    public function getSorts(): array
    {
        return $this->sorts;
    }

    /**
     * @param BuilderInterface[] $sorts
     */
    public function setSorts(array $sorts): self
    {
        $this->sorts = $sorts;

        return $this;
    }

    public function addSort(BuilderInterface $sort): self
    {
        $this->sorts[] = $sort;

        return $this;
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

    public function getType(): string
    {
        return 'top_hits';
    }

    public function getArray(): array|stdClass
    {
        $sortsOutput = [];
        $addedSorts = array_filter($this->getSorts());
        if ($addedSorts !== []) {
            foreach ($addedSorts as $sort) {
                $sortsOutput[] = $sort->toArray();
            }
        } else {
            $sortsOutput = null;
        }

        $output = array_filter(
            [
                'sort' => $sortsOutput,
                'size' => $this->getSize(),
                'from' => $this->getFrom(),
            ],
            static fn ($value) => $value !== null
        );

        return $output === [] ? new stdClass() : $output;
    }
}
