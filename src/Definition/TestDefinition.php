<?php

declare(strict_types=1);

/*
 * This file is part of Survey CLI app for students.
 *
 * (c) Kamil Szarek <nesskyy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Survey\Definition;

use Assert\Assert;

final class TestDefinition
{
    /** @var array<AbstractQuestionDefinition> */
    private array $questionDefinitions;

    private string $title;

    public function __construct(string $title, AbstractQuestionDefinition ...$questionDefinitions)
    {
        Assert::that($questionDefinitions)->notEmpty();
        Assert::that($questionDefinitions)->maxCount(5);
        $this->title = $title;
        $this->questionDefinitions = $questionDefinitions;
    }

    public function title(): string
    {
        return $this->title;
    }

    /** @return array<AbstractQuestionDefinition> */
    public function questionDefinitions(): array
    {
        return $this->questionDefinitions;
    }
}
