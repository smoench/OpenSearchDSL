<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Aggregation\Pipeline;

use LogicException;

/**
 * Class representing Bucket Script Pipeline Aggregation.
 *
 * @link https://goo.gl/miVxcx
 */
class BucketScriptAggregation extends AbstractPipelineAggregation
{
    private ?string $script = null;

    public function __construct(string $name, string|array|null $bucketsPath = null, string $script = null)
    {
        parent::__construct($name, $bucketsPath);
        $this->setScript($script);
    }

    public function getScript(): ?string
    {
        return $this->script;
    }

    public function setScript(?string $script): self
    {
        $this->script = $script;

        return $this;
    }

    public function getType(): string
    {
        return 'bucket_script';
    }

    public function getArray(): array
    {
        if ($this->getScript() === null) {
            throw new LogicException(
                sprintf(
                    '`%s` aggregation must have script set.',
                    $this->getName()
                )
            );
        }

        return [
            'buckets_path' => $this->getBucketsPath(),
            'script' => $this->getScript(),
        ];
    }
}
