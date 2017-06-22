<?php

namespace AppBundle\Form;

use AppBundle\Entity\MemberSummary\JobExperience;
use AppBundle\Entity\Summary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', TextType::class)
            ->add('position', TextType::class)
            ->add('location', TextType::class)
            ->add('website', TextType::class, [
                'required' => false,
                'empty_data' => null,
            ])
            ->add('company_facebook_page', TextType::class, [
                'required' => false,
                'empty_data' => null,
            ])
            ->add('company_twitter_nickname', TextType::class, [
                'required' => false,
                'empty_data' => null,
            ])
            ->add('started_at', MonthChoiceType::class)
            ->add('ended_at', MonthChoiceType::class, [
                'required' => false,
            ])
            ->add('on_going', CheckboxType::class)
            ->add('contract', ContractChoiceType::class)
            ->add('duration', JobDurationChoiceType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
        ;

        $isNew = (bool) $builder->getData();

        if ($options['summary'] instanceof Summary) {
            $builder->add('position', SummaryItemPositionType::class, [
                'collection' => $options['summary']->getExperiences(),
                'is_new' => $isNew,
            ]);
        }

        $builder->add('submit', SubmitType::class, [
            'label' => $isNew ? 'Ajouter' : 'Modifier',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => JobExperience::class,
                'summary' => null,
            ])
            ->setAllowedTypes('summary', ['null', Summary::class])
        ;
    }
}
