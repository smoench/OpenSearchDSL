<?php

declare(strict_types=1);

namespace OpenSearchDSL\SearchEndpoint;

use InvalidArgumentException;
use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\FieldCollapse\FieldCollapse;
use OverflowException;

class CollapseEndpoint extends AbstractSearchEndpoint
{
    final public const NAME = 'collapse';

    private ?FieldCollapse $collapse = null;

    private ?string $key = null;

    public function normalize(): ?array
    {
        if ($this->collapse instanceof FieldCollapse) {
            return $this->collapse->toArray();
        }

        return null;
    }

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        if (! $builder instanceof FieldCollapse) {
            throw new InvalidArgumentException('Only FieldCollapse can be added');
        }
        if ($this->collapse instanceof FieldCollapse) {
            throw new OverflowException('Only one highlight can be set');
        }

        if (! $key) {
            $key = bin2hex(random_bytes(30));
        }

        $this->key = $key;
        $this->collapse = $builder;

        return $this->key;
    }

    public function getAll(?string $boolType = null): array
    {
        return [
            $this->key => $this->collapse,
        ];
    }

    public function getCollapse(): ?FieldCollapse
    {
        return $this->collapse;
    }
}
