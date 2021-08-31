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

namespace Tests\Unit\Calculator;

use PHPUnit\Framework\TestCase;
use Survey\Answer;
use Survey\Answers;
use Survey\Calculator\RewardOnlyScoreCalculator;
use Survey\Definition\AnswerDefinition;
use Survey\Definition\MultipleAnswerQuestionDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;
use Survey\Definition\TestDefinition;
use Survey\Tests;

class RewardOnlyScoreCalculatorTest extends TestCase
{
    /** @test */
    public function it_calculates_score_only_by_rewarding_correct_answers(): void
    {
        $question1 = new SingleAnswerQuestionDefinition(
            'question_1',
            new AnswerDefinition('q1a1', true, 3),
            new AnswerDefinition('q1a2', false),
        );
        $question2 = new SingleAnswerQuestionDefinition(
            'question_2',
            new AnswerDefinition('q2a1', false),
            new AnswerDefinition('q2a2', true, 10),
        );
        $question3 = new MultipleAnswerQuestionDefinition(
            'question_3',
            new AnswerDefinition('q3a1', true, 5),
            new AnswerDefinition('q3a2', true, 1),
            new AnswerDefinition('q3a3', true, 3),
        );
        $test = new TestDefinition('test_1', $question1, $question2, $question3);
        $tests = new Tests();
        $tests->add($test);

        $answers = new Answers();
        $answers->add(new Answer($question1, 'q1a1'));
        $answers->add(new Answer($question2, 'q2a2'));
        $answers->add(new Answer($question3, ['q3a1', 'q3a2', 'q3a3']));

        $calculator = new RewardOnlyScoreCalculator();
        $this->assertSame(22, $calculator->calculate($answers));
    }
}
