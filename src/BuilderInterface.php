<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL;

use stdClass;

interface BuilderInterface
{
    /**
     * Generates array which will be passed to opensearch-php client.
     *
     * @return array<string, mixed>|stdClass
     */
    public function toArray(): array|stdClass;

    /**
     * Returns element type.
     */
    public function getType(): string;
}
