<?php

namespace AppBundle\Form;

use AppBundle\Summary\SummaryItemDisplayOrderer;
use AppBundle\Summary\SummaryItemPositionableInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SummaryItemPositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isNew = $options['is_new'];
        /** @var Collection|SummaryItemPositionableInterface[] $collection */
        $collection = $options['collection'];

        if ($options['collection']) {
            $count = $collection->count();
            if (0 < $count) {
                $builder->add('entry', ChoiceType::class, [
                    'inherit_data' => true,
                    'choices' => range(1, $isNew ? $count : $count++),
                ]);
            }
        } else {
            $builder->add('entry', HiddenType::class, ['inherit_data' => true]);
        }

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($isNew, $collection) {
            $form = $event->getForm();
            $newPosition = $form->get('entry')->getData();

            SummaryItemDisplayOrderer::updateItemPosition($collection,  $newPosition, $isNew ? $form->getData() : null);
            
            $event->setData($newPosition);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['collection', 'new_item'])
            ->setAllowedTypes('new_item', 'bool')
            ->setAllowedTypes('collection', ['null', Collection::class])
        ;
    }
}
