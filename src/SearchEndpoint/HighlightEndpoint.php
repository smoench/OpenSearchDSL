<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\SearchEndpoint;

use OpenSearchDSL\BuilderInterface;
use OverflowException;

/**
 * Search highlight dsl endpoint.
 */
class HighlightEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'highlight';

    private ?BuilderInterface $highlight = null;

    /**
     * @var string|null Key for highlight storing.
     */
    private ?string $key = null;

    public function normalize(): ?array
    {
        if ($this->highlight !== null) {
            return $this->highlight->toArray();
        }

        return null;
    }

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        if ($this->highlight !== null) {
            throw new OverflowException('Only one highlight can be set');
        }

        if (! $key) {
            $key = bin2hex(random_bytes(30));
        }

        $this->key = $key;
        $this->highlight = $builder;

        return $this->key;
    }

    public function getAll(?string $boolType = null): array
    {
        return [
            $this->key => $this->highlight,
        ];
    }

    public function getHighlight(): ?BuilderInterface
    {
        return $this->highlight;
    }
}
