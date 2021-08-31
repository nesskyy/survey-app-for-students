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

final class ScoreCalculatorRegistry
{
    /** @var array<ScoreCalculator> */
    private array $calculators = [];

    public function register(ScoreCalculator $scoreCalculator): void
    {
        if (\array_key_exists($scoreCalculator->name(), $this->calculators)) {
            throw new \RuntimeException(sprintf('Given `%s` calculator has been registered already.', $scoreCalculator->name()));
        }
        $this->calculators[$scoreCalculator->name()] = $scoreCalculator;
    }

    public function get(string $name): ScoreCalculator
    {
        if (!\array_key_exists($name, $this->calculators)) {
            throw new \RuntimeException(sprintf('Requested calculator with name `%s` does not exist.', $name));
        }

        return $this->calculators[$name];
    }

    /** @return array<string> */
    public function names(): array
    {
        return array_keys($this->calculators);
    }
}
