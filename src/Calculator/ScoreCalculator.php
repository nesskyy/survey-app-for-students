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

use Survey\Answers;

interface ScoreCalculator
{
    public function name(): string;

    public function calculate(Answers $answers): int;
}
