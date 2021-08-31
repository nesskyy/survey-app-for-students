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
use Survey\Definition\TestDefinition;

class TestDefinitionTest extends TestCase
{
    /** @test */
    public function it_has_title(): void
    {
        $questionDefinition = new SingleAnswerQuestionDefinition(
            'some_question',
            new AnswerDefinition('some_answer', true, 5)
        );
        $test = new TestDefinition('Test title', $questionDefinition);
        $this->assertSame('Test title', $test->title());
    }

    /** @test */
    public function it_has_questions(): void
    {
        $questionDefinition = new SingleAnswerQuestionDefinition(
            'some_question',
            new AnswerDefinition('some_answer', true, 5)
        );
        $testDefinition = new TestDefinition(
            'some_title',
            $questionDefinition
        );
        $this->assertSame([$questionDefinition], $testDefinition->questionDefinitions());
    }

    /** @test */
    public function it_fails_if_question_list_is_empty(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new TestDefinition('some_title');
    }

    /** @test */
    public function it_fails_if_questions_count_is_greater_than_five(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $question = new SingleAnswerQuestionDefinition(
            'some_question',
            new AnswerDefinition('some_answer', true, 5)
        );
        new TestDefinition(
            'some_title',
            $question,
            $question,
            $question,
            $question,
            $question,
            $question
        );
    }
}
