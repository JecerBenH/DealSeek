<?php
/**
 * Created by PhpStorm.
 * User: Jecer
 * Date: 05-Mar-21
 * Time: 12:16 AM
 */

namespace App\Form;
use App\Entity\Reclam;

use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Name',TextType::class)
            ->add('Id',IntegerType::class,['required' => false])
            ->add('Email',EmailType::class,['required' => false])
            ->add('Phone',IntegerType::class)
            ->add('Message',TextareaType::class)
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptcha'
            ))
            ->add('Resolu',HiddenType::class,['data' => '0'])
        ;
    }

    /**
     * {@inheritdoc}
     */





}