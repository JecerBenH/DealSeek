<?php
/**
 * Created by PhpStorm.
 * User: Jecer
 * Date: 05-Mar-21
 * Time: 12:16 AM
 */

namespace App\Form;


use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReclamAdminType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',TextType::class,['required' => false])
            ->add('Email',EmailType::class,['required' => false])
            ->add('Phone',IntegerType::class,['required' => false])
            ->add('Message',TextareaType::class,['required' => false])
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptcha'
            ))

        ;
    }

    /**
     * {@inheritdoc}
     */





}