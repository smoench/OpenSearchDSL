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
use OpenSearchDSL\Query\Compound\BoolQuery;
use OpenSearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search query dsl endpoint.
 */
class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    /**
     * Endpoint name
     */
    public const NAME = 'query';

    private ?BoolQuery $bool = null;

    private bool $filtersSet = false;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if (!$this->filtersSet && $this->hasReference('filter_query')) {
            /** @var BuilderInterface $filter */
            $filter = $this->getReference('filter_query');
            $this->addToBool($filter, BoolQuery::FILTER);
            $this->filtersSet = true;
        }

        if ($this->bool === null) {
            return null;
        }

        return $this->bool->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function add(BuilderInterface $builder, $key = null)
    {
        return $this->addToBool($builder, BoolQuery::MUST, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function addToBool(BuilderInterface $builder, $boolType = null, $key = null)
    {
        if ($this->bool === null) {
            $this->bool = new BoolQuery();
        }

        return $this->bool->add($builder, $boolType, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @return BoolQuery
     */
    public function getBool()
    {
        return $this->bool;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null)
    {
        return $this->bool->getQueries($boolType);
    }
}
