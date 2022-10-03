<?php

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
 * Class representing Percentile Ranks Aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-rank-aggregation.html
 */
class PercentileRanksAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    private ?array $values = null;
    private ?int $compression = null;

    public function __construct(
        string $name,
        ?string $field = null,
        ?array $values = null,
        ?string $script = null,
        ?int $compression = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setValues($values);
        $this->setScript($script);
        $this->setCompression($compression);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    public function setValues(?array $values): self
    {
        $this->values = $values;

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
        return 'percentile_ranks';
    }

    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'values' => $this->getValues(),
                'compression' => $this->getCompression(),
            ],
            fn($val) => $val || is_numeric($val)
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    /**
     * @throws LogicException
     */
    private function isRequiredParametersSet(array $a): bool
    {
        if (
            (array_key_exists('field', $a) && array_key_exists('values', $a))
            || (array_key_exists('script', $a) && array_key_exists('values', $a))
        ) {
            return true;
        }
        throw new LogicException('Percentile ranks aggregation must have field and values or script and values set.');
    }
}
