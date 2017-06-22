<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class MonthChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('day')
            ->resetViewTransformers()
            ->addViewTransformer(new DateTimeToArrayTransformer(
                $options['model_timezone'], $options['view_timezone'], array('year', 'month')
            ))
        ;
    }

    public function getParent()
    {
        return DateType::class;
    }
}
