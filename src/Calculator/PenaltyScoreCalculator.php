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

namespace Survey\Calculator;

use Survey\Answer;
use Survey\Answers;

class PenaltyScoreCalculator implements ScoreCalculator
{
    public function name(): string
    {
        return 'Penalty score calculator.';
    }

    public function calculate(Answers $answers): int
    {
        $score = 0;

        /** @var Answer $answer */
        foreach ($answers->all() as $answer) {
            $answerScoreMappings = [];

            foreach ($answer->questionDefinition()->answerDefinitions() as $answerDefinition) {
                $answerScoreMappings[$answerDefinition->answer()] = $answerDefinition->score();
            }

            foreach ($answer->answers() as $userAnswer) {
                $score += $answerScoreMappings[$userAnswer];
            }
        }

        return $score;
    }
}
