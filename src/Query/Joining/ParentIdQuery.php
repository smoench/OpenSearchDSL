<?php

declare(strict_types=1);

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
     */
    public function __construct(
        private $parentId,
        private string $childType,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'parent_id';
    }

    public function toArray(): array
    {
        $query = [
            'id' => $this->parentId,
            'type' => $this->childType,
        ];
        $output = $this->processArray($query);

        return [
            $this->getType() => $output,
        ];
    }
}
