<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Functional\Query;

use OpenSearchDSL\Query\Compound\FunctionScoreQuery;
use OpenSearchDSL\Query\MatchAllQuery;
use OpenSearchDSL\Search;
use OpenSearchDSL\Tests\Functional\AbstractOpenSearchTestCase;

class FunctionScoreQueryTest extends AbstractOpenSearchTestCase
{
    protected function getDataArray()
    {
        return [
            'product' => [
                [
                    'title' => 'acme',
                    'price' => 10,
                ],
                [
                    'title' => 'foo',
                    'price' => 20,
                ],
                [
                    'title' => 'bar',
                    'price' => 10,
                ],
            ],
        ];
    }

    /**
     * Match all test
     */
    public function testRandomScore()
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addRandomFunction();
        $fquery->addParameter('boost_mode', 'multiply');

        $search = new Search();
        $search->addQuery($fquery);
        $results = $this->executeSearch($search, 'product');

        $this->assertCount(
            is_countable($this->getDataArray()['product']) ? count($this->getDataArray()['product']) : 0,
            $results
        );
    }

    public function testScriptScore()
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addScriptScoreFunction(
            "
            if (doc['price'].value < params.target) 
             {
               return doc['price'].value * params.charge; 
             }
             return doc['price'].value;
             ",
            [
                'target' => 10,
                'charge' => 0.9,
            ]
        );

        $search = new Search();
        $search->addQuery($fquery);
        $results = $this->executeSearch($search, 'product');

        foreach ($results as $document) {
            $this->assertLessThanOrEqual(20, $document['price']);
        }
    }
}
