<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
	        ->add('Prenom',TextType::class, ['label' => 'Prénom'])
	        ->add('Email', EmailType::class)
	        ->add('Motif', TextType::class, ['label' => 'Motif de contact'])
	        ->add('Message', TextareaType::class)
	        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
	        'label' => false
        ]);
    }
}
