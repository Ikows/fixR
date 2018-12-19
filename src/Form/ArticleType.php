<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
           /* ->add('slug')*/
           /* ->add('created_at')*/
            ->add('ville')
            ->add('support', ChoiseType::class, array(
                'Selectionnez le support de votre article'=>array(
                    'Texte'=>'stock_texte',
                    'Video'=>'stock_video',
                    'Audio'=>'stock_audio'
                )
            ))
            ->add('contenu')
            ->add('image')
            ->add('auteur')
            ->add('theme')
            ->add('motCle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
