<?php

/**
 * Note type.
 */

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Note;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NoteType.
 */
class NoteType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class, [
            'label' => 'label.title',
            'required' => true,
            'attr' => ['max_length' => 1500],
        ]);

        $builder->add('comment', TextareaType::class, [
            'label' => 'label.comment',
            'required' => false,
            'attr' => [
                'maxlength' => 1500,
                'rows' => 6,
                'class' => 'textarea-wrap',
            ],
        ]);
        $builder->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => fn (Category $category): ?string => $category->getTitle(),
            'label' => 'label.category',
            'placeholder' => 'Kategoria',
            'required' => true,
        ]);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Note::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'note';
    }
}
