<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 15:56
 */

namespace LogBlogBundle\Form\Content;

use LogBlogBundle\Entity\Content\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostWriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('title', TextType::class, [
                'label' => 'title', // TODO: translate
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 255,
                    ])
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'content', // TODO: translate
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 4096,
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }

}