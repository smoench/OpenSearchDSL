<?php

declare(strict_types=1);

namespace OpenSearchDSL\FieldCollapse;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;
use stdClass;

class FieldCollapse implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var list<InnerHits>
     */
    private array $innerHits = [];

    public function __construct(
        private readonly string $field
    ) {
    }

    public function addInnerHits(InnerHits $innerHits): self
    {
        $this->innerHits[] = $innerHits;

        return $this;
    }

    public function getType(): string
    {
        return 'collapse';
    }

    public function toArray(): array|stdClass
    {
        $array = [
            'field' => $this->field,
        ];

        if ($this->innerHits !== []) {
            $array['inner_hits'] = array_map(
                static fn (InnerHits $innerHits) => $innerHits->toArray(),
                $this->innerHits
            );
        }

        return $this->processArray($array);
    }
}
