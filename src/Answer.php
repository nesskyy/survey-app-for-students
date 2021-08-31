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

use Survey\Definition\AbstractQuestionDefinition;

final class Answer
{
    private AbstractQuestionDefinition $questionDefinition;

    /** @var array<string> */
    private array $answers;

    /**
     * @param array<string>|string $answers
     */
    public function __construct(AbstractQuestionDefinition $questionDefinition, array|string $answers)
    {
        if (\is_string($answers)) {
            $answers = [$answers];
        }
        $this->questionDefinition = $questionDefinition;
        $this->answers = $answers;
    }

    /** @return array<string> */
    public function answers(): array
    {
        return $this->answers;
    }

    public function questionDefinition(): AbstractQuestionDefinition
    {
        return $this->questionDefinition;
    }
}
