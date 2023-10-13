<?php

declare(strict_types=1);

namespace OpenSearchDSL\InnerHit;

class ParentInnerHit extends NestedInnerHit
{
    public function getType(): string
    {
        return 'parent';
    }
}
