<?php

namespace OpenSearchDSL\InnerHit;

class ParentInnerHit extends NestedInnerHit
{
    public function getType(): string
    {
        return 'parent';
    }
}
