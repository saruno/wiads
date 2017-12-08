<?php
// src/AppBundle/Form/Type/AdvertiserType.php

namespace AdvertiserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AccesspointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('macaddr', TextType::class)
            ->add('ssid', TextType::class)
            ->add('key', TextType::class, array('required' => false))
            ->add('isp', TextType::class, array('required' => false))
            ->add('province', 'choice', array(
                'choices'   =>  \AdvertiserBundle\Helper\ProvinceHelper::getProvince(),
            ))
            ->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('detail_url', TextType::class, array('required' => false));
            
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotspot\AccessPointBundle\Model\Accesspoint',
        ));
    }

    public function getName()
    {
        return 'accesspoint';
    }
}