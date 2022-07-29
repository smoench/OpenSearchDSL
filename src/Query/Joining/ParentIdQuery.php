<?php

namespace OpenSearchDSL\Query\Joining;

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-parent-id-query.html
 */
class ParentIdQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $parentId
     * @param string $childType
     * @param array  $parameters
     */
    public function __construct(private $parentId, private string $childType, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'parent_id';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'id' => $this->parentId,
            'type' => $this->childType,
        ];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
