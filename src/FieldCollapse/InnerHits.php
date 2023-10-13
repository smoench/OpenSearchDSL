<?php

declare(strict_types=1);

namespace OpenSearchDSL\FieldCollapse;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

class InnerHits implements BuilderInterface
{
    use ParametersTrait;

    private ?FieldCollapse $collapse = null;

    public function __construct(
        private readonly string $name,
    ) {
    }

    public function setFieldCollapse(FieldCollapse $collapse): self
    {
        $this->collapse = $collapse;

        return $this;
    }

    public function getType(): string
    {
        return 'inner_hits';
    }

    public function toArray(): array
    {
        $array = [
            'name' => $this->name,
        ];

        if ($this->collapse instanceof FieldCollapse) {
            $array['collapse'] = $this->collapse->toArray();
        }

        return $this->processArray($array);
    }
}
