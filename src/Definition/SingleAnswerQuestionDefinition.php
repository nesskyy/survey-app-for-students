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

final class SingleAnswerQuestionDefinition extends AbstractQuestionDefinition
{
    public function __construct(string $question, AnswerDefinition ...$answerDefinitions)
    {
        parent::__construct($question, ...$answerDefinitions);
        $this->assertThatExactlyOneCorrectAnswerIsProvided(...$answerDefinitions);
    }

    private function assertThatExactlyOneCorrectAnswerIsProvided(AnswerDefinition ...$answerDefinitions): void
    {
        $successAnswers = array_filter(
            $answerDefinitions,
            static function (AnswerDefinition $answerDefinition) {
                return $answerDefinition->correct();
            }
        );

        if (\count($successAnswers) !== 1) {
            throw new \InvalidArgumentException('Single-answer question must have exactly one correct answer.');
        }
    }
}
