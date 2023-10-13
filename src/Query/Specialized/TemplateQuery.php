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

namespace OpenSearchDSL\Query\Specialized;

use InvalidArgumentException;
use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "template" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-template-query.html
 */
class TemplateQuery implements BuilderInterface
{
    use ParametersTrait;

    private ?string $file = null;

    private ?string $inline = null;

    private array $params;

    /**
     * @param array  $params Parameters to insert into template
     */
    public function __construct(string $file = null, string $inline = null, array $params = [])
    {
        $this->setFile($file);
        $this->setInline($inline);
        $this->setParams($params);
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getInline(): ?string
    {
        return $this->inline;
    }

    public function setInline(?string $inline): self
    {
        $this->inline = $inline;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function getType(): string
    {
        return 'template';
    }

    public function toArray(): array
    {
        $output = array_filter(
            [
                'file' => $this->getFile(),
                'inline' => $this->getInline(),
                'params' => $this->getParams(),
            ]
        );

        if (! isset($output['file']) && ! isset($output['inline'])) {
            throw new InvalidArgumentException(
                'Template query requires that either `inline` or `file` parameters are set'
            );
        }

        $output = $this->processArray($output);

        return [
            $this->getType() => $output,
        ];
    }
}
