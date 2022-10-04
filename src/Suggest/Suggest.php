<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Suggest;

use OpenSearchDSL\NamedBuilderInterface;
use OpenSearchDSL\ParametersTrait;

class Suggest implements NamedBuilderInterface
{
    use ParametersTrait;

    private string $name;

    private string $type;

    private string $text;

    private string $field;

    public function __construct(string $name, string $type, string $text, string $field, array $parameters = [])
    {
        $this->setName($name);
        $this->setType($type);
        $this->setText($text);
        $this->setField($field);
        $this->setParameters($parameters);
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns suggest name
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->getName() => [
                'text' => $this->getText(),
                $this->getType() => $this->processArray([
                    'field' => $this->getField(),
                ]),
            ],
        ];
    }
}
