<?php
// src/AppBundle/Form/Type/AdvertiserType.php

namespace AdvertiserBundle\Form\Type;


use AdvertiserBundle\AdvertiserBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AdvertiserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Section collection
        /*$builder->add('section', 'model', array(
            'class' => 'Common\DbBundle\Model\Section',
            'property' => 'title',
            'index_property' => 'id'
        ));*/

        // Select Customer
        /*$builder->add('customer', 'model', array(
            'class' =>  'Common\DbBundle\Model\Customer',
            'property' =>   'username',
            'index_property' => 'id'
        ));*/
        $builder->add('locked', ChoiceType::class, array(
            'choices'  => array(
                '1'    => 'Khóa',
                '0'    => 'Kích hoạt',
            ),
            
        ));

        $builder
            ->add('campagin', TextType::class)
            ->add('description', TextareaType::class,array(

            ))
            ->add('link', UrlType::class,array('required' => false))
            ->add('link_to', UrlType::class,array('required' => false))
            ->add('title', TextType::class)
            ->add('published_at', TextType::class)
            ->add('expired_at', TextType::class)
            ->add('home_position', 'choice', array(
                'choices'   =>  \AdvertiserBundle\Helper\AdvertiserPositionHelper::Item(),
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Common\DbBundle\Model\Advert',
        ));
    }

    public function getName()
    {
        return 'advert';
    }
}