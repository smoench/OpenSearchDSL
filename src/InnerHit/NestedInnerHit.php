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

namespace OpenSearchDSL\InnerHit;

use OpenSearchDSL\NameAwareTrait;
use OpenSearchDSL\NamedBuilderInterface;
use OpenSearchDSL\ParametersTrait;
use OpenSearchDSL\Search;
use stdClass;

/**
 * Represents Elasticsearch top level nested inner hits.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
 */
class NestedInnerHit implements NamedBuilderInterface
{
    use ParametersTrait;
    use NameAwareTrait;

    private string $path;

    private ?Search $search = null;

    /**
     * Inner hits container init.
     *
     * @param string $name
     * @param string $path
     */
    public function __construct($name, $path, Search $search = null)
    {
        $this->setName($name);
        $this->setPath($path);
        if ($search instanceof \OpenSearchDSL\Search) {
            $this->setSearch($search);
        }
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Search
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return $this
     */
    public function setSearch(Search $search)
    {
        $this->search = $search;

        return $this;
    }

    public function getType(): string
    {
        return 'nested';
    }

    public function toArray(): array
    {
        $out = $this->getSearch() ? $this->getSearch()->toArray() : new stdClass();

        return [
            $this->getPathType() => [
                $this->getPath() => $out,
            ],
        ];
    }

    /**
     * Returns 'path' for nested and 'type' for parent inner hits
     *
     * @return null|string
     */
    private function getPathType()
    {
        return match ($this->getType()) {
            'nested' => 'path',
            'parent' => 'type',
            default => null,
        };
    }
}
