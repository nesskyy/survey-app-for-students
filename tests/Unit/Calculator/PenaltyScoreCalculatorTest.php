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
use Survey\Calculator\PenaltyScoreCalculator;
use Survey\Definition\AnswerDefinition;
use Survey\Definition\MultipleAnswerQuestionDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;
use Survey\Definition\TestDefinition;
use Survey\Tests;

class PenaltyScoreCalculatorTest extends TestCase
{
    /** @test */
    public function it_adds_score_for_correct_answers_and_subtracts_for_incorrect_for_single_answer_questions(): void
    {
        $question1 = new SingleAnswerQuestionDefinition(
            'question_1',
            new AnswerDefinition('q1a1', true, 3),
            new AnswerDefinition('q1a2', false, -5),
        );
        $question2 = new SingleAnswerQuestionDefinition(
            'question_2',
            new AnswerDefinition('q2a1', false),
            new AnswerDefinition('q2a2', true, 10),
        );
        $test = new TestDefinition('test_1', $question1, $question2);
        $tests = new Tests();
        $tests->add($test);

        $answers = new Answers();
        $answers->add(new Answer($question1, 'q1a2'));
        $answers->add(new Answer($question2, 'q2a2'));

        $calculator = new PenaltyScoreCalculator();
        $this->assertSame(5, $calculator->calculate($answers));
    }

    /** @test */
    public function it_omits_non_selected_correct_answer_scores_and_subtracts_incorrect_answers_for_multiple_answer_questions(): void
    {
        $question1 = new MultipleAnswerQuestionDefinition(
            'question_1',
            new AnswerDefinition('q1a1', true, 3),
            new AnswerDefinition('q1a2', false),
        );
        $question2 = new MultipleAnswerQuestionDefinition(
            'question_2',
            new AnswerDefinition('q2a1', true, 5),
            new AnswerDefinition('q2a2', true, 10),
        );
        $question3 = new MultipleAnswerQuestionDefinition(
            'question_3',
            new AnswerDefinition('q3a1', true, 2),
            new AnswerDefinition('q3a2', true, 10),
            new AnswerDefinition('q3a3', false, -9),
        );
        $test = new TestDefinition('test_1', $question1, $question2, $question3);
        $tests = new Tests();
        $tests->add($test);

        $answers = new Answers();
        $answers->add(new Answer($question1, ['q1a1']));
        $answers->add(new Answer($question2, ['q2a2']));
        $answers->add(new Answer($question3, ['q3a1', 'q3a3']));

        $calculator = new PenaltyScoreCalculator();
        $this->assertSame(6, $calculator->calculate($answers));
    }

    /** @test */
    public function it_calculates_mixed_question_types(): void
    {
        $question1 = new MultipleAnswerQuestionDefinition(
            'question_1',
            new AnswerDefinition('q1a1', true, 3),
            new AnswerDefinition('q1a2', false),
        );
        $question2 = new MultipleAnswerQuestionDefinition(
            'question_2',
            new AnswerDefinition('q2a1', true, 5),
            new AnswerDefinition('q2a2', true, 10),
        );
        $question3 = new MultipleAnswerQuestionDefinition(
            'question_3',
            new AnswerDefinition('q3a1', true, 2),
            new AnswerDefinition('q3a2', true, 10),
            new AnswerDefinition('q3a3', false, -9),
        );
        $question4 = new SingleAnswerQuestionDefinition(
            'question_4',
            new AnswerDefinition('q4a1', true, 3),
            new AnswerDefinition('q4a2', false, -5),
        );
        $question5 = new SingleAnswerQuestionDefinition(
            'question_5',
            new AnswerDefinition('q5a1', false, -1),
            new AnswerDefinition('q5a2', true, 10),
        );
        $test = new TestDefinition('test_1', $question1, $question2, $question3, $question4, $question5);
        $tests = new Tests();
        $tests->add($test);

        $answers = new Answers();
        $answers->add(new Answer($question1, ['q1a1']));
        $answers->add(new Answer($question2, ['q2a1', 'q2a2']));
        $answers->add(new Answer($question3, ['q3a1', 'q3a2']));
        $answers->add(new Answer($question4, 'q4a1'));
        $answers->add(new Answer($question5, 'q5a2'));

        $calculator = new PenaltyScoreCalculator();
        $this->assertSame(43, $calculator->calculate($answers));
    }
}
