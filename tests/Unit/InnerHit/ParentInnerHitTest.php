<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\InnerHit;

use ONGR\ElasticsearchDSL\InnerHit\ParentInnerHit;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;
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
