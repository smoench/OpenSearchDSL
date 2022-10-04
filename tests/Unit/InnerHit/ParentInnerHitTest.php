<?php

namespace OpenSearchDSL\Tests\Unit\InnerHit;

use OpenSearchDSL\InnerHit\ParentInnerHit;
use OpenSearchDSL\Query\TermLevel\TermQuery;
use OpenSearchDSL\Search;
use PHPUnit\Framework\TestCase;

class ParentInnerHitTest extends TestCase
{
    public function testToArray()
    {
        $query = new TermQuery('foo', 'bar');
        $search = new Search();
        $search->addQuery($query);

        $hit = new ParentInnerHit('test', 'acme', $search);
        $expected = [
            'type' => [
                'acme' => [
                    'query' => $query->toArray(),
                ],
            ],
        ];
        $this->assertEquals($expected, $hit->toArray());
    }
}
