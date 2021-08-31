#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php';

use Survey\Answer;
use Survey\Answers;
use Survey\Calculator\PenaltyScoreCalculator;
use Survey\Calculator\RewardOnlyScoreCalculator;
use Survey\Calculator\ScoreCalculatorRegistry;
use Survey\Definition\AbstractQuestionDefinition;
use Survey\Definition\AnswerDefinition;
use Survey\Definition\MultipleAnswerQuestionDefinition;
use Survey\Definition\SingleAnswerQuestionDefinition;
use Survey\Definition\TestDefinition;
use Survey\Tests;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Console\Style\SymfonyStyle;

$question1 = new SingleAnswerQuestionDefinition(
    'Is snow white?',
    new AnswerDefinition('Yes', true, 3),
    new AnswerDefinition('No', false),
);
$question2 = new SingleAnswerQuestionDefinition(
    'Are frogs cute?',
    new AnswerDefinition('Yes', false),
    new AnswerDefinition('No', true, 10),
);
$question3 = new MultipleAnswerQuestionDefinition(
    'How many candies would you like to have?',
    new AnswerDefinition('One', false, -5),
    new AnswerDefinition('Two', true, 1),
    new AnswerDefinition('Three', true, 3),
);
$test1 = new TestDefinition('Test 1', $question1, $question2, $question3);
$tests = new Tests();
$tests->add($test1);

$scoreCalculatorRegistry = new ScoreCalculatorRegistry();
$scoreCalculatorRegistry->register(new RewardOnlyScoreCalculator());
$scoreCalculatorRegistry->register(new PenaltyScoreCalculator());

$appName = 'SIMPLE SURVEY APP';
$application = new SingleCommandApplication();

$application->setName($appName)
    ->setCode(static function (InputInterface $input, OutputInterface $output) use ($tests, $application, $appName, $scoreCalculatorRegistry): void {
        $questionHelper = $application->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $io->title($appName);
        $question = new ChoiceQuestion('Please select test you\'d like to fill:', $tests->titles());
        $chosenTestTitle = $questionHelper->ask($input, $output, $question);

        $question = new ChoiceQuestion('Please select calculator strategy:', $scoreCalculatorRegistry->names());
        $chosenScoreCalculatorStrategyName = $questionHelper->ask($input, $output, $question);
        $scoreCalculatorStrategy = $scoreCalculatorRegistry->get($chosenScoreCalculatorStrategyName);

        $io->info(
            sprintf(
                'You\'ve selected `%s` test with `%s` score calculation strategy. Answer the questions now...',
                $chosenTestTitle,
                $chosenScoreCalculatorStrategyName
            )
        );

        $chosenTest = $tests->get($chosenTestTitle);

        $answers = new Answers();

        /** @var AbstractQuestionDefinition $questionDefinition */
        foreach ($chosenTest->questionDefinitions() as $questionDefinition) {
            $answerDefinitionAnswers = array_map(
                static fn (AnswerDefinition $answerDefinition) => $answerDefinition->answer(),
                $questionDefinition->answerDefinitions()
            );
            $question = new ChoiceQuestion($questionDefinition->question(), $answerDefinitionAnswers);

            if ($questionDefinition instanceof MultipleAnswerQuestionDefinition) {
                $question->setMultiselect(true);
            }
            $answers->add(
                new Answer(
                    $questionDefinition,
                    $questionHelper->ask($input, $output, $question)
                )
            );
        }

        $totalScore = $scoreCalculatorStrategy->calculate($answers);

        $io->success(sprintf('You\'ve successfully finished the test with the total score: %d', $totalScore));
    })
    ->run();
