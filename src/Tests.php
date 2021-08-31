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

use Survey\Definition\TestDefinition;

final class Tests
{
    /** @var array<TestDefinition> */
    private array $testDefinitions = [];

    public function add(TestDefinition $testDefinition): void
    {
        if (\array_key_exists($testDefinition->title(), $this->testDefinitions)) {
            throw new \RuntimeException(sprintf('Test with title `%s` does already exist.', $testDefinition->title()));
        }

        $this->testDefinitions[$testDefinition->title()] = $testDefinition;
    }

    public function get(string $title): TestDefinition
    {
        if (!\array_key_exists($title, $this->testDefinitions)) {
            throw new \RuntimeException(sprintf('Test with title `%s` does not exist.', $title));
        }

        return $this->testDefinitions[$title];
    }

    /** @return array<string> */
    public function titles(): array
    {
        return array_keys($this->testDefinitions);
    }
}
