<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $question = $options['question'];

        $builder->add('answers', EntityType::class, [
            'class' => Answer::class,
            'choices' => $question->getAnswers(),
            'choice_label' => 'value',
            'expanded' => true,
            'multiple' => true,
            'label' => $question->getTitle(),
        ])->add('id', HiddenType::class, ['data' => $question->getId()]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'question' => null,
        ]);
    }
}
