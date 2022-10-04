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

use OpenSearchDSL\Query\MatchAllQuery;
use OpenSearchDSL\Search;
use OpenSearchDSL\Tests\Functional\AbstractOpenSearchTestCase;

class MatchAllQueryTest extends AbstractOpenSearchTestCase
{
    protected function getDataArray()
    {
        return [
            'product' => [
                [
                    'title' => 'acme',
                ],
                [
                    'title' => 'foo',
                ],
            ],
        ];
    }

    /**
     * Match all test
     */
    public function testMatchAll()
    {
        $search = new Search();
        $matchAll = new MatchAllQuery();

        $search->addQuery($matchAll);
        $q = $search->getQueries();
        $results = $this->executeSearch($search);

        $this->assertEquals($this->getDataArray()['product'], $results);
    }
}
