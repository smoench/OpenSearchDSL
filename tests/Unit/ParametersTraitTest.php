<?php

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

/**
 * Test for ParametersTrait.
 */
class ParametersTraitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ParametersTrait
     */
    private $parametersTraitMock;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->parametersTraitMock = $this->getMockForTrait('OpenSearchDSL\ParametersTrait');
    }

    /**
     * Tests addParameter method.
     */
    public function testGetAndAddParameter()
    {
        $this->assertTrue(is_object($this->parametersTraitMock->addParameter('acme', 123)));
        $this->assertEquals(123, $this->parametersTraitMock->getParameter('acme'));
        $this->parametersTraitMock->addParameter('bar', 321);
        $this->assertEquals(321, $this->parametersTraitMock->getParameter('bar'));
        $this->assertTrue(is_object($this->parametersTraitMock->removeParameter('acme')));
    }
}
