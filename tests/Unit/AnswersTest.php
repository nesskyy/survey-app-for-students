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

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Survey\Answer;
use Survey\Answers;
use Survey\Definition\AnswerDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;

class AnswersTest extends TestCase
{
    /** @test */
    public function it_adds_answers(): void
    {
        $answer1 = new Answer(
            new SingleAnswerQuestionDefinition(
                'question_definition_1',
                new AnswerDefinition('answer_1', true, 5)
            ),
            'some_answer'
        );
        $answer2 = new Answer(
            new SingleAnswerQuestionDefinition(
                'question_definition_2',
                new AnswerDefinition('answer_1', true, 5)
            ),
            'some_answer'
        );

        $answers = new Answers();
        $answers->add($answer1);
        $answers->add($answer2);

        $this->assertSame(
            [$answer1, $answer2],
            $answers->all()
        );
    }
}
