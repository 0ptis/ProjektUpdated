<?php

/*
 * User Type
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use App\Entity\User;

/**
 * Defines the form for a User entity, including fields for email and password.
 *
 * The form includes validation constraints and ensures proper password confirmation
 * by using repeated fields. It also sets the data class to User.
 */
class UserType extends AbstractType
{
    /**
     * Builds the form by adding fields and their constraints.
     *
     * @param FormBuilderInterface $builder the form builder instance used for constructing the form
     * @param array                $options an array of options for the form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class)
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'required' => false,
            'first_options'  => ['label' => 'New password'],
            'second_options' => ['label' => 'Repeat password'],
            'constraints' => [
                new Length(['min' => 6]),
            ],
        ]);
    }

    /**
     * Configures the user class.
     *
     * @param OptionsResolver $resolver Options resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
