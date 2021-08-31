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

namespace Survey;

final class Answers
{
    /** @var array<Answer> */
    private array $answers = [];

    public function add(Answer $answer): void
    {
        $this->answers[] = $answer;
    }

    /** @return array<Answer> */
    public function all(): array
    {
        return $this->answers;
    }
}
