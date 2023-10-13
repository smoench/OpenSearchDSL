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

namespace OpenSearchDSL\Query\Compound;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;
use stdClass;
use UnexpectedValueException;

/**
 * Represents Elasticsearch "bool" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery implements BuilderInterface
{
    use ParametersTrait;

    public const MUST = 'must';

    public const MUST_NOT = 'must_not';

    public const SHOULD = 'should';

    public const FILTER = 'filter';

    /**
     * @var array<string, array<string, BuilderInterface>>
     */
    private array $container = [];

    /**
     * Constructor to prepare container.
     *
     * @param array<string, BuilderInterface|BuilderInterface[]> $container
     */
    public function __construct(array $container = [])
    {
        foreach ($container as $type => $queries) {
            $queries = is_array($queries) ? $queries : [$queries];

            array_walk($queries, function ($query) use ($type) {
                $this->add($query, $type);
            });
        }
    }

    /**
     * Returns the query instances (by bool type).
     *
     * @return array<string, BuilderInterface>
     */
    public function getQueries(?string $boolType = null): array
    {
        if ($boolType === null) {
            $queries = [];

            foreach ($this->container as $item) {
                $queries = array_merge($queries, $item);
            }

            return $queries;
        }

        return $this->container[$boolType] ?? [];
    }

    /**
     * Add BuilderInterface object to bool operator.
     *
     * @param BuilderInterface $query Query add to the bool.
     * @param string           $type  Bool type. Example: must, must_not, should.
     * @param string|null      $key   Key that indicates a builder id.
     *
     * @return string Key of added builder.
     *
     * @throws UnexpectedValueException
     */
    public function add(BuilderInterface $query, string $type = self::MUST, ?string $key = null): string
    {
        if (! in_array($type, [self::MUST, self::MUST_NOT, self::SHOULD, self::FILTER], true)) {
            throw new UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }

        if ($key === null) {
            $key = bin2hex(random_bytes(30));
        }

        $this->container[$type][$key] = $query;

        return $key;
    }

    public function toArray(): array
    {
        if (
            count($this->container) === 1 && isset($this->container[self::MUST])
                && (is_countable($this->container[self::MUST]) ? count($this->container[self::MUST]) : 0) === 1
        ) {
            $query = reset($this->container[self::MUST]);

            return $query->toArray();
        }

        $output = [];

        foreach ($this->container as $boolType => $builders) {
            foreach ($builders as $builder) {
                $output[$boolType][] = $builder->toArray();
            }
        }

        $output = $this->processArray($output);

        if ($output === []) {
            $output = new stdClass();
        }

        return [
            $this->getType() => $output,
        ];
    }

    public function getType(): string
    {
        return 'bool';
    }
}
