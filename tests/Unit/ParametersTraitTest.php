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

namespace OpenSearchDSL\Tests\Unit;

use OpenSearchDSL\ParametersTrait;
use PHPUnit\Framework\TestCase;

class ParametersTraitTest extends TestCase
{
    private object $parametersTraitMock;

    protected function setUp(): void
    {
        $this->parametersTraitMock = new class() {
            use ParametersTrait;
        };
    }

    /**
     * Tests addParameter method.
     */
    public function testGetAndAddParameter(): void
    {
        $this->assertIsObject($this->parametersTraitMock->addParameter('acme', 123));
        $this->assertEquals(123, $this->parametersTraitMock->getParameter('acme'));
        $this->parametersTraitMock->addParameter('bar', 321);
        $this->assertEquals(321, $this->parametersTraitMock->getParameter('bar'));
        $this->assertIsObject($this->parametersTraitMock->removeParameter('acme'));
    }
}
