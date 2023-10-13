<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\FullText;

use OpenSearchDSL\Query\FullText\CommonTermsQuery;
use PHPUnit\Framework\TestCase;

class CommonTermsQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new CommonTermsQuery('body', 'this is bonsai cool', [
            'cutoff_frequency' => 0.01,
        ]);
        $expected = [
            'common' => [
                'body' => [
                    'query' => 'this is bonsai cool',
                    'cutoff_frequency' => 0.01,
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
