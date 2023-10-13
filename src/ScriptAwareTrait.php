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

namespace OpenSearchDSL;

/**
 * A trait which handles elasticsearch aggregation script.
 */
trait ScriptAwareTrait
{
    private ?string $script = null;

    public function getScript(): ?string
    {
        return $this->script;
    }

    public function setScript(?string $script): static
    {
        $this->script = $script;

        return $this;
    }
}
