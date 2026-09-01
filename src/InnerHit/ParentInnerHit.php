<?php

declare(strict_types=1);

namespace OpenSearchDSL\InnerHit;

class ParentInnerHit extends NestedInnerHit
{
    #[\Override]
    public function getType(): string
    {
        return 'parent';
    }
}
