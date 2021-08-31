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
use Survey\Answers;
use Survey\Calculator\ScoreCalculator;
use Survey\Calculator\ScoreCalculatorRegistry;

class ScoreCalculatorRegistryTest extends TestCase
{
    /** @test */
    public function it_registers(): void
    {
        $calculator = $this->createFooScoreCalculator();

        $registry = new ScoreCalculatorRegistry();
        $registry->register($calculator);

        $this->assertSame(
            $registry->get($calculator->name()),
            $calculator
        );
    }

    /** @test */
    public function it_fails_if_registering_calculators_are_not_unique(): void
    {
        $this->expectException(\RuntimeException::class);

        $calculator1 = $this->createFooScoreCalculator();
        $calculator2 = $this->createFooScoreCalculator();

        $registry = new ScoreCalculatorRegistry();
        $registry->register($calculator1);
        $registry->register($calculator2);
    }

    /** @test */
    public function it_fails_if_trying_to_get_non_existing_calculator(): void
    {
        $this->expectException(\RuntimeException::class);

        $registry = new ScoreCalculatorRegistry();
        $registry->get('non_existing_calculator');
    }

    /** @test */
    public function it_returns_all_registered_calculator_names(): void
    {
        $calculator1 = $this->createFooScoreCalculator();
        $calculator2 = $this->createBarScoreCalculator();

        $registry = new ScoreCalculatorRegistry();
        $registry->register($calculator1);
        $registry->register($calculator2);

        $this->assertSame(
            ['foo', 'bar'],
            $registry->names()
        );
    }

    private function createFooScoreCalculator(): ScoreCalculator
    {
        return new class implements ScoreCalculator {
            public function calculate(Answers $answers): int
            {
                return 0;
            }

            public function name(): string
            {
                return 'foo';
            }
        };
    }

    private function createBarScoreCalculator(): ScoreCalculator
    {
        return new class implements ScoreCalculator {
            public function calculate(Answers $answers): int
            {
                return 0;
            }

            public function name(): string
            {
                return 'bar';
            }
        };
    }
}
