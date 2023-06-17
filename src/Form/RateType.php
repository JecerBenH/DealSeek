<?php
namespace App\Form;

use Brokoskokoli\StarRatingBundle\Form\RatingType;
use Brokoskokoli\StarRatingBundle\Form\StarRatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;

/**
 * Created by PhpStorm.
 * User: Jecer
 * Date: 28-Aug-21
 * Time: 4:48 PM
 */

class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', StarRatingType::class, [
            'label' => 'Rating'
        ])
            ->add('submit',SubmitType::class)        ;

    }
}