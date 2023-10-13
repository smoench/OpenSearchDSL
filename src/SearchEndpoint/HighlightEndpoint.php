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

namespace OpenSearchDSL\SearchEndpoint;

use InvalidArgumentException;
use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\Highlight\Highlight;
use OverflowException;

/**
 * Search highlight dsl endpoint.
 */
class HighlightEndpoint extends AbstractSearchEndpoint
{
    final public const NAME = 'highlight';

    private ?Highlight $highlight = null;

    private ?string $key = null;

    public function normalize(): ?array
    {
        if ($this->highlight instanceof Highlight) {
            return $this->highlight->toArray();
        }

        return null;
    }

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        if (! $builder instanceof Highlight) {
            throw new InvalidArgumentException('Only highlight can be added');
        }
        if ($this->highlight instanceof Highlight) {
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

    public function getHighlight(): ?Highlight
    {
        return $this->highlight;
    }
}
