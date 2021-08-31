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

class AnswerDefinitionTest extends TestCase
{
    /** @test */
    public function it_contains_answer(): void
    {
        $definition = new AnswerDefinition('answer', false, -1);
        $this->assertSame('answer', $definition->answer());
    }

    /** @test */
    public function it_has_score(): void
    {
        $definition = new AnswerDefinition('answer', true, 5);
        $this->assertSame(5, $definition->score());
    }

    /** @test */
    public function it_has_correctness(): void
    {
        $definition = new AnswerDefinition('answer', true, 5);
        $this->assertTrue($definition->correct());
    }

    /** @test */
    public function it_must_have_positive_or_zero_score_if_answer_is_correct(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new AnswerDefinition('answer', true, -1);
    }

    /** @test */
    public function it_must_have_negative_or_zero_score_if_answer_is_incorrect(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new AnswerDefinition('answer', false, 1);
    }
}
