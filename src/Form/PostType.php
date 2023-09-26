<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      /*
      ->add('category', ChoiceType::class, [
        'choices' => [
          //'PHP' => 'php',
          //'Laravel' => 'laravel',
          //'Symfony' => 'symfony',
          //'Codeigniter' => 'codeigniter'
          'Languages' => [
            'PHP' => 'php'
          ],
          'Frameworks' => [
            'Laravel' => 'laravel',
            'Symfony' => 'symfony',
            'Codeigniter' => 'codeigniter'
          ]
        ],
        'placeholder' => 'Seleccione una...',
        'label' => 'Categorias'
      ])
      */
      ->add('category', EntityType::class, [
        'class' => Category::class,
        'placeholder' => 'Seleccione una...',
        'label' => 'Categorias',
        //'required' => false
      ])
      ->add('title', TextType::class, [
        'label' => 'Titulo de la publicación',
        'help' => 'Piensa en el SEO',
        'required' => false
      ])
      ->add('body', TextareaType::class, [
        'label' => 'Contenido',
        'attr' => ['rows' => 9, 'class' => 'bg-light'],
        //'required' => false
      ])
      ->add('Enviar', SubmitType::class, [
        'attr' => ['class' => 'btn btn-dark']
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Post::class,
      //'csrf_protection' => false
    ]);
  }
}
