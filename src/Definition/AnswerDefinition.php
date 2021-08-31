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

use Assert\Assert;

final class AnswerDefinition
{
    private string $answer;

    private bool $correct;

    private int $points;

    public function __construct(string $answer, bool $correct, int $score = 0)
    {
        $correct ? Assert::that($score)->greaterOrEqualThan(0) : Assert::that($score)->lessOrEqualThan(0);
        Assert::that($answer)->minLength(1);

        $this->answer = $answer;
        $this->correct = $correct;
        $this->points = $score;
    }

    public function answer(): string
    {
        return $this->answer;
    }

    public function correct(): bool
    {
        return $this->correct;
    }

    public function score(): int
    {
        return $this->points;
    }
}
