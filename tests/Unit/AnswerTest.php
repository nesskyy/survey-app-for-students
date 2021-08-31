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
use Survey\Definition\AnswerDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;

class AnswerTest extends TestCase
{
    /** @test */
    public function it_normalizes_given_answers_to_array(): void
    {
        $questionDefinition = new SingleAnswerQuestionDefinition(
            'some_question_definition',
            new AnswerDefinition('some_answer', true, 5)
        );
        $answer = new Answer($questionDefinition, 'some_answer');
        $this->assertSame(
            ['some_answer'],
            $answer->answers()
        );
    }

    /** @test */
    public function it_has_question_definition(): void
    {
        $questionDefinition = new SingleAnswerQuestionDefinition(
            'some_question_definition',
            new AnswerDefinition('some_answer', true, 5)
        );
        $answer = new Answer($questionDefinition, 'some_answer');
        $this->assertSame(
            $questionDefinition,
            $answer->questionDefinition()
        );
    }
}
