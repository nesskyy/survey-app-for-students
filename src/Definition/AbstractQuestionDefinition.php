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

abstract class AbstractQuestionDefinition
{
    /** @var array<AnswerDefinition> */
    private array $answerDefinitions;

    private string $question;

    public function __construct(string $question, AnswerDefinition ...$answerDefinitions)
    {
        Assert::that($question)->minLength(3);
        $this->assertThatAnswerDefinitionsAreUnique(...$answerDefinitions);
        $this->question = $question;
        $this->answerDefinitions = $answerDefinitions;
    }

    public function question(): string
    {
        return $this->question;
    }

    /** @return array<AnswerDefinition> */
    public function answerDefinitions(): array
    {
        return $this->answerDefinitions;
    }

    private function assertThatAnswerDefinitionsAreUnique(AnswerDefinition ...$answerDefinitions): void
    {
        $answerDefinitionTitles = array_map(
            static fn (AnswerDefinition $answerDefinition) => $answerDefinition->answer(),
            $answerDefinitions
        );

        if (\count($answerDefinitions) !== \count(array_unique($answerDefinitionTitles))) {
            throw new \InvalidArgumentException('Answer definitions must be unique.');
        }
    }
}
