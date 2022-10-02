<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\SearchEndpoint;

use OpenSearchDSL\BuilderInterface;
use OverflowException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search highlight dsl endpoint.
 */
class HighlightEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'highlight';

    private ?BuilderInterface $highlight = null;

    /**
     * @var string Key for highlight storing.
     */
    private $key;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = []): array|string|int|float|bool
    {
        if ($this->highlight !== null) {
            return $this->highlight->toArray();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function add(BuilderInterface $builder, $key = null)
    {
        if ($this->highlight !== null) {
            throw new OverflowException('Only one highlight can be set');
        }

        $this->key = $key;
        $this->highlight = $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null)
    {
        return [$this->key => $this->highlight];
    }

    /**
     * @return BuilderInterface
     */
    public function getHighlight()
    {
        return $this->highlight;
    }
}
