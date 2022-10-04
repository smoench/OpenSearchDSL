<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Query\Specialized;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "more_like_this" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
 */
class MoreLikeThisQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $like
     */
    public function __construct(
        private $like,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'more_like_this';
    }

    public function toArray(): array
    {
        $query = [];

        if ((! $this->hasParameter('ids')) || (! $this->hasParameter('docs'))) {
            $query['like'] = $this->like;
        }

        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
