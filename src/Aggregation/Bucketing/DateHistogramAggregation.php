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

/**
 * Class representing Histogram aggregation.
 *
 * @link https://goo.gl/hGCdDd
 */
class DateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?string $interval = null;

    private ?string $format = null;

    public function __construct(string $name, ?string $field = null, ?string $interval = null, ?string $format = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setInterval($interval);
        $this->setFormat($format);
    }

    public function getInterval(): string
    {
        return $this->interval;
    }

    public function setInterval(?string $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getType(): string
    {
        return 'date_histogram';
    }

    public function getArray(): array
    {
        if (! $this->getField() || ! $this->getInterval()) {
            throw new LogicException('Date histogram aggregation must have field and interval set.');
        }

        $out = [
            'field' => $this->getField(),
            'interval' => $this->getInterval(),
        ];

        if (! empty($this->format)) {
            $out['format'] = $this->format;
        }

        return $out;
    }
}
