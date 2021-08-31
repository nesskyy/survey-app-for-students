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

class RewardOnlyScoreCalculator implements ScoreCalculator
{
    public function calculate(Answers $answers): int
    {
        $score = 0;

        /** @var Answer $answer */
        foreach ($answers->all() as $answer) {
            foreach ($answer->questionDefinition()->answerDefinitions() as $answerDefinition) {
                if ($answerDefinition->correct() && \in_array($answerDefinition->answer(), $answer->answers(), true)) {
                    $score += $answerDefinition->score();
                }
            }
        }

        return $score;
    }

    public function name(): string
    {
        return 'Reward only score calculator.';
    }
}
