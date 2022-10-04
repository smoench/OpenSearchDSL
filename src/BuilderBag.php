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

/**
 * Container for named builders.
 */
class BuilderBag
{
    /**
     * @var BuilderInterface[]
     */
    private array $bag = [];

    /**
     * @param BuilderInterface[] $builders
     */
    public function __construct(array $builders = [])
    {
        foreach ($builders as $builder) {
            $this->add($builder);
        }
    }

    public function add(BuilderInterface $builder): string
    {
        $name = method_exists($builder, 'getName') ? $builder->getName() : bin2hex(random_bytes(30));

        $this->bag[$name] = $builder;

        return $name;
    }

    /**
     * Checks if builder exists by a specific name.
     */
    public function has(string $name): bool
    {
        return isset($this->bag[$name]);
    }

    /**
     * Removes a builder by name.
     */
    public function remove(string $name): void
    {
        unset($this->bag[$name]);
    }

    /**
     * Clears contained builders.
     */
    public function clear(): void
    {
        $this->bag = [];
    }

    /**
     * Returns a builder by name.
     */
    public function get(string $name): BuilderInterface
    {
        return $this->bag[$name];
    }

    /**
     * Returns all builders contained.
     *
     * @param string|null $type Builder type.
     *
     * @return BuilderInterface[]
     */
    public function all(string $type = null): array
    {
        return array_filter(
            $this->bag,
            static fn (BuilderInterface $builder) => $type === null || $builder->getType() === $type
        );
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->all() as $builder) {
            $output = array_merge($output, $builder->toArray());
        }

        return $output;
    }
}
