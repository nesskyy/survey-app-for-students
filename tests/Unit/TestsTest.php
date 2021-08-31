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

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Survey\Definition\AnswerDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;
use Survey\Definition\TestDefinition;
use Survey\Tests;

class TestsTest extends TestCase
{
    /** @test */
    public function it_can_add_test(): void
    {
        $tests = new Tests();
        $test = new TestDefinition(
            'some_title',
            new SingleAnswerQuestionDefinition(
                'some_question',
                new AnswerDefinition('some_answer', true, 1)
            )
        );

        $tests->add($test);

        $this->assertSame($test, $tests->get('some_title'));
    }

    /** @test */
    public function it_fails_if_test_with_title_already_exists_in_the_collection(): void
    {
        $this->expectException(\RuntimeException::class);

        $tests = new Tests();
        $test = new TestDefinition(
            'some_title',
            new SingleAnswerQuestionDefinition(
                'some_question',
                new AnswerDefinition('some_answer', true, 1)
            )
        );

        $tests->add($test);
        $tests->add($test);
    }

    /** @test */
    public function it_fails_if_trying_to_get_non_existing_test(): void
    {
        $this->expectException(\RuntimeException::class);

        $tests = new Tests();
        $tests->get('non_existing_test');
    }

    /** @test */
    public function it_returns_test_titles(): void
    {
        $tests = new Tests();
        $test1 = new TestDefinition(
            'Example test 1',
            new SingleAnswerQuestionDefinition(
                'some_question',
                new AnswerDefinition('some_answer', true, 1)
            )
        );
        $test2 = new TestDefinition(
            'Example test 2',
            new SingleAnswerQuestionDefinition(
                'some_question',
                new AnswerDefinition('some_answer', true, 1)
            )
        );

        $tests->add($test1);
        $tests->add($test2);

        $this->assertSame(
            [
                'Example test 1',
                'Example test 2',
            ],
            $tests->titles()
        );
    }
}
