<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\Joining;

use OpenSearchDSL\Query\Joining\HasParentQuery;
use PHPUnit\Framework\TestCase;

class HasParentQueryTest extends TestCase
{
    /**
     * Tests whether __constructor calls setParameters method.
     */
    public function testConstructor()
    {
        $parentQuery = $this->getMockBuilder('OpenSearchDSL\BuilderInterface')->getMock();
        $query = new HasParentQuery('test_type', $parentQuery, ['test_parameter1']);
        $this->assertEquals(['test_parameter1'], $query->getParameters());
    }
}
