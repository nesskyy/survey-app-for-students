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

namespace Tests\Unit\Definition;

use PHPUnit\Framework\TestCase;
use Survey\Definition\AnswerDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;

class SingleAnswerQuestionDefinitionTest extends TestCase
{
    /** @test */
    public function it_has_question_name(): void
    {
        $questionDefinition = new SingleAnswerQuestionDefinition(
            'Does wine has alcohol?',
            new AnswerDefinition('answer_one', true, 1)
        );
        $this->assertSame('Does wine has alcohol?', $questionDefinition->question());
    }

    /** @test */
    public function it_fails_if_question_has_less_than_three_characters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new SingleAnswerQuestionDefinition('12');
    }

    /** @test */
    public function it_fails_if_answer_definitions_are_not_unique(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SingleAnswerQuestionDefinition(
            'some_question',
            new AnswerDefinition('answer', true, 1),
            new AnswerDefinition('answer', false, -1)
        );
    }

    /** @test */
    public function it_has_answer_definitions(): void
    {
        $answerDefinition1  = new AnswerDefinition('answer_one', true, 1);
        $answerDefinition2  = new AnswerDefinition('answer_two', false, -1);
        $questionDefinition = new SingleAnswerQuestionDefinition(
            'some_question',
            $answerDefinition1,
            $answerDefinition2
        );

        $this->assertSame(
            [$answerDefinition1, $answerDefinition2],
            $questionDefinition->answerDefinitions()
        );
    }

    /** @test */
    public function it_fails_if_does_not_have_exactly_one_correct_answer_definition(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SingleAnswerQuestionDefinition(
            'some_question',
            new AnswerDefinition('answer_one', true, 1),
            new AnswerDefinition('answer_two', true, 1),
            new AnswerDefinition('answer_three', false, -1)
        );
    }
}
