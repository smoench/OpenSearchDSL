<?php

namespace OpenSearchDSL\InnerHit;

class ParentInnerHit extends NestedInnerHit
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'parent';
    }
}
