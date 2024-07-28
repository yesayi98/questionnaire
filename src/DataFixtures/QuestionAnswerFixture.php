<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionAnswerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Define a set of questions and answers
        $data = [
            [
                'title' => '1 + 1 =',
                'answers' => [
                    ['text' => '3', 'is_right' => false],
                    ['text' => '2', 'is_right' => true],
                    ['text' => '0', 'is_right' => false],
                ],
            ],
            [
                'title' => '2 + 2 =',
                'answers' => [
                    ['text' => '4', 'is_right' => true],
                    ['text' => '3 + 1', 'is_right' => true],
                    ['text' => '10', 'is_right' => false],
                ],
            ],
            [
                'title' => '3 + 3 =',
                'answers' => [
                    ['text' => '1 + 5', 'is_right' => true],
                    ['text' => '1', 'is_right' => false],
                    ['text' => '6', 'is_right' => true],
                    ['text' => '2 + 4', 'is_right' => true],
                ],
            ],
            [
                'title' => '4 + 4 =',
                'answers' => [
                    ['text' => '8', 'is_right' => true],
                    ['text' => '4', 'is_right' => false],
                    ['text' => '0', 'is_right' => false],
                    ['text' => '0 + 8', 'is_right' => true],
                ],
            ],
            [
                'title' => '5 + 5 =',
                'answers' => [
                    ['text' => '6', 'is_right' => false],
                    ['text' => '18', 'is_right' => false],
                    ['text' => '10', 'is_right' => true],
                    ['text' => '9', 'is_right' => false],
                    ['text' => '0', 'is_right' => false],
                ],
            ],
            [
                'title' => '6 + 6 =',
                'answers' => [
                    ['text' => '3', 'is_right' => false],
                    ['text' => '9', 'is_right' => false],
                    ['text' => '0', 'is_right' => false],
                    ['text' => '12', 'is_right' => true],
                    ['text' => '5 + 7', 'is_right' => true],
                ],
            ],
            [
                'title' => '7 + 7 =',
                'answers' => [
                    ['text' => '5', 'is_right' => false],
                    ['text' => '14', 'is_right' => true],
                ],
            ],
            [
                'title' => '8 + 8 =',
                'answers' => [
                    ['text' => '16', 'is_right' => true],
                    ['text' => '12', 'is_right' => false],
                    ['text' => '9', 'is_right' => false],
                    ['text' => '5', 'is_right' => false],
                ],
            ],
            [
                'title' => '9 + 9 =',
                'answers' => [
                    ['text' => '18', 'is_right' => true],
                    ['text' => '9', 'is_right' => false],
                    ['text' => '17 + 1', 'is_right' => true],
                    ['text' => '2 + 16', 'is_right' => true],
                ],
            ],
            [
                'title' => '10 + 10 =',
                'answers' => [
                    ['text' => '0', 'is_right' => false],
                    ['text' => '2', 'is_right' => false],
                    ['text' => '8', 'is_right' => false],
                    ['text' => '20', 'is_right' => true],
                ],
            ],
        ];

        foreach ($data as $questionData) {
            $question = new Question();
            $question->setTitle($questionData['title']);

            $manager->persist($question);

            foreach ($questionData['answers'] as $answerData) {
                $answer = new Answer();
                $answer->setValue($answerData['text']);
                $answer->setRight($answerData['is_right']);
                $answer->setQuestion($question); // Set the association

                $manager->persist($answer);
            }
        }

        $manager->flush();
    }
}
