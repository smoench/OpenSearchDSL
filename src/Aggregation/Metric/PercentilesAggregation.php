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

use LogicException;
use OpenSearchDSL\Aggregation\AbstractAggregation;
use OpenSearchDSL\Aggregation\Type\MetricTrait;
use OpenSearchDSL\ScriptAwareTrait;

/**
 * Class representing PercentilesAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-aggregation.html
 */
class PercentilesAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    private ?array $percents = null;

    private ?int $compression = null;

    public function __construct(
        string $name,
        ?string $field = null,
        ?array $percents = null,
        ?string $script = null,
        ?int $compression = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setPercents($percents);
        $this->setScript($script);
        $this->setCompression($compression);
    }

    public function getPercents(): ?array
    {
        return $this->percents;
    }

    public function setPercents(?array $percents): self
    {
        $this->percents = $percents;

        return $this;
    }

    public function getCompression(): ?int
    {
        return $this->compression;
    }

    public function setCompression(?int $compression): self
    {
        $this->compression = $compression;

        return $this;
    }

    public function getType(): string
    {
        return 'percentiles';
    }

    public function getArray(): array
    {
        $out = array_filter(
            [
                'compression' => $this->getCompression(),
                'percents' => $this->getPercents(),
                'field' => $this->getField(),
                'script' => $this->getScript(),
            ],
            fn ($val) => $val || is_numeric($val)
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    /**
     * @throws LogicException
     */
    private function isRequiredParametersSet(array $a): void
    {
        if (! array_key_exists('field', $a) && ! array_key_exists('script', $a)) {
            throw new LogicException('Percentiles aggregation must have field or script set.');
        }
    }
}
