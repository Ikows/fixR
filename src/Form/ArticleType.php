<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\MotCle;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
           /* ->add('slug')*/
           /* ->add('created_at')*/
            ->add('ville')
            ->add('support', ChoiceType::class, array(
                'choices'=>array(
                    'Texte'=>'stock_texte',
                    'Video'=>'stock_video',
                    'Audio'=>'stock_audio'
                )
            ))
            ->add('contenu')
            ->add('image')
           /* ->add('auteur')*/
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                   'choice_label' => 'titre'
               ]
           )
            ->add('motCle', EntityType::class, [
                'class' => MotCle::class,
                'choice_label' => 'titre',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
